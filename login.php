<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>VetTakip Pro - Ulusal Ortak Klinik Ağı</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<nav class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container d-flex justify-content-between">
        <span class="navbar-brand fw-bold text-primary"><i class="fas fa-network-wired"></i> VetTakip Ortak Portalı</span>
        <div class="d-flex gap-2">
            <button class="btn btn-primary fw-bold text-white shadow-sm" data-bs-toggle="modal" data-bs-target="#sahiplenModal">
                <i class="fas fa-heart me-1"></i> 🐾 Yuvaya İhtiyacı Olan Canlar
            </button>
            <button class="btn btn-danger fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#yardimModal">
                <i class="fas fa-hands-helping me-1"></i> Klinik Yardımlaşma Duvarı
            </button>
        </div>
    </div>
</nav>

<div class="container my-auto">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-info shadow-sm text-center fw-bold mb-3"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <div class="card shadow border-0 p-4 mb-4 bg-white rounded-4">
                <h3 class="fw-bold text-center mb-3 text-dark">Sistem Giriş Kapısı</h3>
                <div class="d-flex gap-2 mb-4">
                    <button type="button" id="btnAdmin" class="btn btn-primary w-100 fw-bold py-2 shadow-sm" onclick="selectRole('admin')">Veteriner Hekim</button>
                    <button type="button" id="btnCustomer" class="btn btn-sm btn-outline-secondary w-100 fw-bold py-2 shadow-sm" onclick="selectRole('customer')">Hasta Sahibi</button>
                </div>
                
                <form action="index.php?action=loginCheck" method="POST">
                    <input type="hidden" name="role" id="selectedRole" value="admin">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">Kullanıcı Adı</label>
                        <input type="text" name="username" class="form-control form-control-lg bg-light border-0" placeholder="Kullanıcı adınız..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">Şifre</label>
                        <input type="password" name="password" class="form-control form-control-lg bg-light border-0" placeholder="••••••" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg w-100 fw-bold shadow-sm py-2">Giriş Yap</button>
                    <div class="text-center mt-3">
                        <a href="index.php?action=register" class="text-decoration-none small text-primary fw-bold">Evcil Hayvanımla Yeni Hesap Aç</a>
                    </div>
                </form>
            </div>

            <div class="card shadow border-0 p-4 bg-white rounded-4">
                <h4 class="fw-bold text-center text-success mb-3"><i class="fas fa-clinic-medical"></i> Yeni Veteriner Dükkanı Dahil Et</h4>
                <form action="index.php?action=veterinerRegister" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Klinik / Dükkan Resmi Adı</label>
                        <input type="text" name="klinik_adi" class="form-control bg-light border-0" placeholder="Örn: Hendek Pati Sağlığı" required>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label small fw-bold text-secondary">Kullanıcı Adı</label>
                            <input type="text" name="username" class="form-control bg-light border-0" required>
                        </div>
                        <div class="col mb-3">
                            <label class="form-label small fw-bold text-secondary">Şifre</label>
                            <input type="password" name="password" class="form-control bg-light border-0" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-outline-success w-100 fw-bold py-2"><i class="fas fa-check-circle me-1"></i> Kliniği Ağa Dahil Et</button>
                </form>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="sahiplenModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold"><i class="fas fa-heart me-2"></i> Yuvaya İhtiyacı Olan Canlar</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body bg-light p-4">
                <div class="row g-3">
                    <?php foreach($ilanlar as $ilan): ?>
                    <div class="col-md-12 bg-white p-3 border rounded shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="fw-bold text-uppercase text-dark mb-1"><i class="fas fa-paw text-primary me-1"></i> <?= htmlspecialchars($ilan['isim']) ?></h4>
                                <p class="text-muted mb-1"><strong>Tür / Cins:</strong> <?= htmlspecialchars($ilan['tur']) ?> / <?= htmlspecialchars($ilan['cins']) ?></p>
                                <p class="text-secondary small mb-0"><strong>Kaldığı Veteriner:</strong> <?= htmlspecialchars($ilan['klinik_adi']) ?></p>
                            </div>
                            <button class="btn btn-success fw-bold px-3 py-2" onclick="openSahiplenForm(<?= $ilan['id'] ?>, '<?= htmlspecialchars($ilan['isim']) ?>', '<?= htmlspecialchars($ilan['tur']) ?>', '<?= htmlspecialchars($ilan['cins']) ?>', '<?= htmlspecialchars($ilan['klinik_adi']) ?>')">
                                <i class="fas fa-hand-holding-heart me-1"></i> Bilgileri İncele & Sahiplen
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div id="basvuruFormuAlani" class="card shadow border-0 p-3 mt-4 bg-warning bg-opacity-25 border-warning rounded-3 d-none">
                    <h5 class="fw-bold text-dark mb-2"><i class="fas fa-file-signature me-1"></i> Sahiplenme İstek ve Başvuru Formu</h5>
                    <form action="index.php?action=sendSahiplenBasvuru" method="POST">
                        <input type="hidden" name="pet_id" id="form_pet_id">
                        <div class="row small g-2 mb-2">
                            <div class="col"><label class="fw-bold">Hayvan Adı:</label> <input type="text" id="form_pet_name" class="form-control form-control-sm" readonly></div>
                            <div class="col"><label class="fw-bold">Tür/Cins:</label> <input type="text" id="form_pet_details" class="form-control form-control-sm" readonly></div>
                            <div class="col"><label class="fw-bold">İlgili Klinik:</label> <input type="text" id="form_pet_clinic" class="form-control form-control-sm" readonly></div>
                        </div>
                        <div class="row g-2">
                            <div class="col"><input type="text" name="ad_soyad" class="form-control form-control-sm" placeholder="Adınız Soyadınız" required></div>
                            <div class="col"><input type="text" name="telefon" class="form-control form-control-sm" placeholder="Telefon Numaranız" required></div>
                            <div class="col-auto"><button type="submit" class="btn btn-dark btn-sm fw-bold px-3">Başvuruyu İlet</button></div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="yardimModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold"><i class="fas fa-hands-helping me-2"></i> Klinikler Arası Yardımlaşma Panosu</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3 bg-light">
                <?php foreach($yardimlar as $yd): ?>
                <div class="alert alert-warning border-0 shadow-sm mb-3 text-dark">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h6 class="fw-bold mb-0 text-danger"><?= htmlspecialchars($yd['baslik']) ?></h6>
                        <span class="badge bg-dark"><?= htmlspecialchars($yd['ilan_turu']) ?></span>
                    </div>
                    <p class="small mb-1 text-secondary"><?= htmlspecialchars($yd['detay']) ?></p>
                    <hr class="my-1">
                    <small class="text-muted d-block text-end">Talep Sahibi: <strong><?= htmlspecialchars($yd['olusturan_klinik']) ?></strong></small>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function selectRole(role) {
    document.getElementById('selectedRole').value = role;
    if(role === 'admin') {
        document.getElementById('btnAdmin').className = "btn btn-primary w-100 fw-bold py-2 shadow-sm";
        document.getElementById('btnCustomer').className = "btn btn-outline-secondary w-100 fw-bold py-2 shadow-sm";
    } else {
        document.getElementById('btnAdmin').className = "btn btn-outline-primary w-100 fw-bold py-2 shadow-sm";
        document.getElementById('btnCustomer').className = "btn btn-secondary w-100 fw-bold py-2 text-white shadow-sm";
    }
}

function openSahiplenForm(id, name, tur, cins, klinik) {
    document.getElementById('form_pet_id').value = id;
    document.getElementById('form_pet_name').value = name.toUpperCase();
    document.getElementById('form_pet_details').value = tur + " (" + cins + ")";
    document.getElementById('form_pet_clinic').value = klinik;
    document.getElementById('basvuruFormuAlani').classList.remove('d-none');
}
</script>
</body>
</html>