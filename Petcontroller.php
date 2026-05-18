<?php
class PetController {
    
    public function loginPage($db) { 
        $yardimlar = $db->query("SELECT * FROM yardim_ilanlari ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
        $ilanlar = $db->query("SELECT * FROM pets WHERE sahiplendirme = 'Sahiplendirme İlanında' ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
        require_once 'app/views/login.php'; 
    }
    
    public function registerPage() { 
        global $db;
        $klinikler = $db->query("SELECT DISTINCT klinik_adi FROM users WHERE role = 'admin' AND klinik_adi IS NOT NULL")->fetchAll(PDO::FETCH_ASSOC);
        require_once 'app/views/register.php'; 
    }

    public function veterinerRegister($db) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sql = "INSERT INTO users (username, password, role, klinik_adi) VALUES (:username, :password, 'admin', :klinik_adi)";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                'username' => $_POST['username'],
                'password' => $_POST['password'],
                'klinik_adi' => $_POST['klinik_adi']
            ]);
            $_SESSION['error'] = "Veteriner kliniğiniz başarıyla kaydedildi! Giriş yapabilirsiniz.";
            header("Location: index.php?action=login"); 
            exit;
        }
    }

    public function registerCheck($db) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $klinik_adi = $_POST['klinik_adi'];

            $sqlPet = "INSERT INTO pets (isim, tur, cins, sahibi, telefon, durum, belirtiler, klinik_adi) 
                       VALUES (:isim, :tur, 'Belirtilmedi', :sahibi, :telefon, 'Bekliyor', 'İlk muayene bekleniyor.', :klinik_adi)";
            $stmtPet = $db->prepare($sqlPet);
            $stmtPet->execute([
                'isim' => $_POST['isim'], 
                'tur' => $_POST['tur'], 
                'sahibi' => $_POST['sahibi'], 
                'telefon' => $_POST['telephone'],
                'klinik_adi' => $klinik_adi
            ]);
            $petId = $db->lastInsertId();

            $sqlUser = "INSERT INTO users (username, password, role, pet_id) VALUES (:username, :password, 'customer', :pet_id)";
            $stmtUser = $db->prepare($sqlUser);
            $stmtUser->execute(['username' => $_POST['username'], 'password' => $_POST['password'], 'pet_id' => $petId]);

            $_SESSION['error'] = "Kullanıcı hesabınız oluşturuldu, giriş yapabilirsiniz.";
            header("Location: index.php?action=login"); 
            exit;
        }
    }

    public function customerSavePet($db) {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') { 
            header("Location: index.php?action=login"); 
            exit; 
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Mevcut görüntülenen hayvanın bilgilerinden sahibini ve kliniğini alıyoruz
            $currentPetStmt = $db->prepare("SELECT sahibi, telefon, klinik_adi FROM pets WHERE id = :id");
            $currentPetStmt->execute(['id' => $_SESSION['pet_id']]);
            $currentPet = $currentPetStmt->fetch(PDO::FETCH_ASSOC);

            $sql = "INSERT INTO pets (isim, tur, cins, sahibi, telefon, durum, belirtiler, tedavi, klinik_adi) 
                    VALUES (:isim, :tur, :cins, :sahibi, :telefon, 'Bekliyor', 'Yeni eklenen ek evcil hayvan.', 'İlk muayene bekleniyor.', :klinik_adi)";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                'isim' => $_POST['isim'],
                'tur' => $_POST['tur'],
                'cins' => $_POST['cins'],
                'sahibi' => $currentPet['sahibi'], // Orijinal sahip adı buraya aktarılıyor
                'telefon' => $currentPet['telefon'],
                'klinik_adi' => $currentPet['klinik_adi']
            ]);
            
            $newPetId = $db->lastInsertId();
            header("Location: index.php?action=view&id=" . $newPetId);
            exit;
        }
    }

    public function sendSahiplenBasvuru($db) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pet_id = intval($_POST['pet_id']);
            $sql = "UPDATE pets SET basvuru_yapan = :basvuru_yapan, basvuru_tel = :basvuru_tel, basvuru_durumu = 'Beklemede' WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                'basvuru_yapan' => $_POST['ad_soyad'],
                'basvuru_tel' => $_POST['telefon'],
                'id' => $pet_id
            ]);
            $_SESSION['error'] = "Sahiplenme başvurunuz başarıyla ilgili veteriner kliniğine iletilmiştir!";
            header("Location: index.php?action=login");
            exit;
        }
    }

    public function updateBasvuru($db) {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { 
            header("Location: index.php?action=login"); 
            exit; 
        }
        if (isset($_GET['id']) && isset($_GET['status'])) {
            $id = intval($_GET['id']);
            $status = $_GET['status'];

            if ($status === 'Onaylandı') {
                $sql = "UPDATE pets SET basvuru_durumu = 'Onaylandı', sahiplendirme = 'Hayır', sahibi = basvuru_yapan, telefon = basvuru_tel WHERE id = :id";
            } else {
                $sql = "UPDATE pets SET basvuru_durumu = 'Yok', basvuru_yapan = NULL, basvuru_tel = NULL WHERE id = :id";
            }

            $stmt = $db->prepare($sql);
            $stmt->execute(['id' => $id]);
        }
        header("Location: index.php?action=list");
        exit;
    }

    public function saveYardim($db) {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { 
            header("Location: index.php?action=login"); 
            exit; 
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sql = "INSERT INTO yardim_ilanlari (baslik, detay, ilan_turu, olusturan_klinik) VALUES (:baslik, :detay, :ilan_turu, :olusturan_klinik)";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                'baslik' => $_POST['baslik'], 
                'detay' => $_POST['detay'],
                'ilan_turu' => $_POST['ilan_turu'], 
                'olusturan_klinik' => $_SESSION['klinik_adi']
            ]);
            header("Location: index.php?action=list"); 
            exit;
        }
    }

    public function veterinerSavePet($db) {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { 
            header("Location: index.php?action=login"); 
            exit; 
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sahibi = !empty($_POST['sahibi']) ? $_POST['sahibi'] : 'Sokak Hayvanı (Sahipsiz)';
            $telefon = !empty($_POST['telefon']) ? $_POST['telefon'] : 'Girilmedi';

            $sql = "INSERT INTO pets (isim, tur, cins, sahibi, telefon, durum, belirtiler, tedavi, sahiplendirme, klinik_adi) 
                    VALUES (:isim, :tur, :cins, :sahibi, :telefon, :durum, :belirtiler, 'İlk muayene yapıldı.', :sahiplendirme, :klinik_adi)";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                'isim' => $_POST['isim'], 
                'tur' => $_POST['tur'], 
                'cins' => $_POST['cins'],
                'sahibi' => $sahibi, 
                'telefon' => $telefon, 
                'durum' => $_POST['durum'],
                'belirtiler' => $_POST['belirtiler'], 
                'sahiplendirme' => $_POST['sahiplendirme'],
                'klinik_adi' => $_SESSION['klinik_adi']
            ]);
            header("Location: index.php?action=list"); 
            exit;
        }
    }

    public function loginCheck($db) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username']; 
            $password = $_POST['password']; 
            $role = $_POST['role'];
            
            $stmt = $db->prepare("SELECT * FROM users WHERE username = :username AND password = :password AND role = :role");
            $stmt->execute(['username' => $username, 'password' => $password, 'role' => $role]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $_SESSION['user_id'] = $user['id']; 
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role']; 
                $_SESSION['pet_id'] = $user['pet_id'];
                $_SESSION['klinik_adi'] = $user['klinik_adi'];
                
                if ($user['role'] === 'admin') { 
                    header("Location: index.php?action=list"); 
                } else { 
                    header("Location: index.php?action=view&id=" . $user['pet_id']); 
                }
                exit;
            } else {
                $_SESSION['error'] = "Hatalı giriş bilgileri!";
                header("Location: index.php?action=login"); 
                exit;
            }
        }
    }

    public function logout() { 
        session_destroy(); 
        header("Location: index.php?action=login"); 
        exit; 
    }

    public function index($db) {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { 
            header("Location: index.php?action=login"); 
            exit; 
        }
        $klinikAdi = isset($_SESSION['klinik_adi']) ? $_SESSION['klinik_adi'] : 'Genel Merkez';
        $stmt = $db->prepare("SELECT * FROM pets WHERE klinik_adi = :klinik ORDER BY id DESC");
        $stmt->execute(['klinik' => $klinikAdi]);
        $pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once 'app/views/pet_list.php';
    }

    //  Liste eşleşmesi hem sahibin ismine hem de ilk açılan ana hayvana göre çift kontrolle bağlanıyor
    public function view($db, $id) {
        if (!isset($_SESSION['role'])) { 
            header("Location: index.php?action=login"); 
            exit; 
        }
        
        require_once 'app/models/Petmodel.php';
        $petModel = new Petmodel($db);
        $pet = $petModel->getById($id);

        $otherPets = [];
        if ($_SESSION['role'] === 'customer') {
            // İlk kayıt olunan ana hayvanın sahibinin adını çekiyoruz
            $mainPetStmt = $db->prepare("SELECT sahibi FROM pets WHERE id = :main_id");
            $mainPetStmt->execute(['main_id' => $_SESSION['pet_id']]);
            $mainPet = $mainPetStmt->fetch(PDO::FETCH_ASSOC);
            $sahipAdi = $mainPet['sahibi'];

            // Giriş yapan kullanıcının adına VEYA ilk hayvanın sahibinin adına göre tüm listeyi eksiksiz buluyoruz
            $stmtOther = $db->prepare("SELECT id, isim, tur FROM pets WHERE sahibi = :sahip1 OR sahibi = :sahip2 ORDER BY id DESC");
            $stmtOther->execute([
                'sahip1' => $_SESSION['username'],
                'sahip2' => $sahipAdi
            ]);
            $otherPets = $stmtOther->fetchAll(PDO::FETCH_ASSOC);
        }

        require_once 'app/views/pet_detail.php';
    }
}
?>