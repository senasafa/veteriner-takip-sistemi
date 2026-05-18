<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>VetTakip - Hasta Sahibi Kayıt Ol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-dark d-flex align-items-center" style="height: 100vh;">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4 shadow border-0 rounded-4 bg-white">
                <div class="text-center mb-3">
                    <i class="fas fa-user-plus fa-3x text-success mb-2"></i>
                    <h4 class="fw-bold text-secondary">Hasta Sahibi Kayıt Paneli</h4>
                    <p class="text-muted small">Klinik sistemine bağlanmak için bilgileri doldurun</p>
                </div>

                <form action="index.php?action=registerCheck" method="POST">
                    
                    <h6 class="fw-bold text-success border-bottom pb-1 mb-2"><i class="fas fa-clinic-medical me-1"></i> Bağlanılacak Veteriner Kliniği</h6>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Kayıt Olacağınız Klinik</label>
                        <select name="klinik_adi" class="form-select form-select-sm bg-light border-0 py-2 fw-bold" required>
                            <option value="">-- Lütfen Gittiğiniz Kliniği Seçin --</option>
                            <?php foreach($klinikler as $kl): ?>
                                <option value="<?= htmlspecialchars($kl['klinik_adi']) ?>"><?= htmlspecialchars($kl['klinik_adi']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <h6 class="fw-bold text-success border-bottom pb-1 mb-2"><i class="fas fa-user me-1"></i> Kişisel Bilgiler</h6>
                    <div class="mb-2">
                        <label class="form-label small fw-bold text-secondary">Adınız Soyadınız</label>
                        <input type="text" name="sahibi" class="form-control form-control-sm bg-light border-0" placeholder="Örn: Ahmet Yılmaz" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-bold text-secondary">Telefon Numaranız</label>
                        <input type="tel" name="telephone" class="form-control form-control-sm bg-light border-0" placeholder="05XXXXXXXXX" required>
                    </div>

                    <h6 class="fw-bold text-success border-bottom pb-1 mt-3 mb-2"><i class="fas fa-paw me-1"></i> Evcil Hayvan Bilgileri</h6>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label small fw-bold text-secondary">Hayvanın Adı</label>
                            <input type="text" name="isim" class="form-control form-control-sm bg-light border-0" placeholder="Örn: Pamuk" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label small fw-bold text-secondary">Türü</label>
                            <select name="tur" class="form-select form-select-sm bg-light border-0">
                                <option value="Kedi">Kedi</option>
                                <option value="Köpek">Köpek</option>
                                <option value="Kuş">Kuş</option>
                            </select>
                        </div>
                    </div>

                    <h6 class="fw-bold text-success border-bottom pb-1 mt-3 mb-2"><i class="fas fa-lock me-1"></i> Giriş Bilgileri</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Kullanıcı Adı</label>
                            <input type="text" name="username" class="form-control form-control-sm bg-light border-0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Şifre</label>
                            <input type="password" name="password" class="form-control form-control-sm bg-light border-0" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100 fw-bold py-2 mb-2 shadow-sm">Klinik Sistemine Bağlan ve Kaydol</button>
                    <div class="text-center">
                        <a href="index.php?action=login" class="text-decoration-none small text-muted"><i class="fas fa-arrow-left me-1"></i> Giriş Ekranına Dön</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>