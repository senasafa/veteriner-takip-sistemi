<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Hasta Girişi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-5">
            <div class="card shadow border-0">
                <div class="card-header bg-success text-white p-3">
                    <h4 class="mb-0 fw-bold"><i class="fas fa-plus-circle me-2"></i> Yeni Hasta Kabul Formu</h4>
                </div>
                
                <div class="card-body p-4">
                    <form action="<?= base_url('pet/store') ?>" method="POST">
                        <div class="row">
                            
                            <h5 class="text-success mb-3 fw-bold border-bottom pb-2"><i class="fas fa-paw me-2"></i> Hayvan Bilgileri</h5>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Hayvanın Adı</label>
                                <input type="text" name="isim" class="form-control" placeholder="Örn: Pamuk" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Türü</label>
                                <select name="tur" class="form-select">
                                    <option value="Kedi">Kedi</option>
                                    <option value="Köpek">Köpek</option>
                                    <option value="Kuş">Kuş</option>
                                    <option value="Egzotik">Egzotik</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Cinsi</label>
                                <input type="text" name="cins" class="form-control" placeholder="Örn: Tekir, Golden">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Cinsiyet</label>
                                <select name="cinsiyet" class="form-select">
                                    <option value="Erkek">Erkek</option>
                                    <option value="Dişi">Dişi</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Ağırlık (KG)</label>
                                <input type="number" step="0.1" name="kilo" class="form-control" placeholder="Örn: 4.5">
                            </div>

                            <h5 class="text-success mt-4 mb-3 fw-bold border-bottom pb-2"><i class="fas fa-user me-2"></i> Sahip Bilgileri</h5>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Sahibinin Adı Soyadı</label>
                                <input type="text" name="sahibi" class="form-control" placeholder="Müşteri ad soyad" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Telefon Numarası</label>
                                <input type="tel" name="telefon" class="form-control" placeholder="05XXXXXXXXX" required>
                            </div>

                            <h5 class="text-success mt-4 mb-3 fw-bold border-bottom pb-2"><i class="fas fa-stethoscope me-2"></i> İlk Muayene Girişi</h5>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Sağlık Durumu</label>
                                <select name="durum" class="form-select">
                                    <option value="Stabil">Stabil (Genel Durumu İyi)</option>
                                    <option value="Tedavide">Tedavide (Rutin Kontrol / Aşı)</option>
                                    <option value="Kritik">Kritik (Acil Müdahale / Yoğun Bakım)</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Şikayet / Muayene / Teşhis Notları</label>
                                <textarea name="notlar" class="form-control" rows="3" placeholder="Geliş sebebi, uygulanan aşı veya tedavi detayları..."></textarea>
                            </div>

                            <div class="col-md-12 mt-4 d-flex justify-content-between">
                                <a href="<?= base_url('pet') ?>" class="btn btn-outline-secondary px-4 fw-bold">İptal Et</a>
                                <button type="submit" class="btn btn-success px-5 fw-bold">Sisteme Kaydet</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>