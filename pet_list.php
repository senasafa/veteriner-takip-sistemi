<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>VetTakip - Kontrol Paneli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar { height: 100vh; background: #212529; color: white; position: fixed; }
        .main-content { margin-left: 250px; padding: 30px; }
        .nav-link.active-menu { background: #0d6efd; color: white !important; border-radius: 5px; }
    </style>
</head>
<body class="bg-light">

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar p-3">
            <h4 class="fw-bold text-primary mb-2"><i class="fas fa-paw"></i> VET-MVC</h4>
            <div class="small text-muted mb-3 border-bottom pb-2"><?= htmlspecialchars($_SESSION['klinik_adi'] ?? 'Genel Merkez') ?></div>
            <div class="badge bg-danger p-2 mb-4 w-100">YETKİ: KLİNİK HEKİMİ</div>
            <ul class="nav flex-column gap-2">
                <li class="nav-item"><a class="nav-link text-white active-menu" href="index.php?action=list"><i class="fas fa-th me-2"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="index.php?action=logout"><i class="fas fa-sign-out-alt me-2"></i> Çıkış Yap</a></li>
            </ul>
        </div>

        <div class="col-md-10 main-content">
            <div class="row mb-4">
                <div class="col-md-7">
                    <h2 class="fw-bold mb-4">Bizim Klinik Hastalarimiz</h2>
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-0">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>İsim</th>
                                        <th>Tür</th>
                                        <th>Sahip</th>
                                        <th>Durum</th>
                                        <th class="text-end">İşlem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($pets as $pet): ?>
                                    <tr>
                                        <td class="fw-bold text-uppercase">
                                            <?= htmlspecialchars($pet['isim']) ?>
                                            <?php if($pet['basvuru_durumu'] == 'Beklemede'): ?>
                                                <span class="badge bg-danger ms-2"><i class="fas fa-bell"></i> Başvuru Geldi!</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($pet['tur']) ?> <small class="text-muted">(<?= htmlspecialchars($pet['cins']) ?>)</small></td>
                                        <td><span class="badge bg-secondary"><?= htmlspecialchars($pet['sahibi']) ?></span></td>
                                        <td>
                                            <?php 
                                            $bColor = 'bg-warning text-dark';
                                            if($pet['durum'] == 'İyi') $bColor = 'bg-success';
                                            if($pet['durum'] == 'Bekliyor') $bColor = 'bg-info text-white';
                                            ?>
                                            <span class="badge <?= $bColor ?> px-3 py-2"><?= htmlspecialchars($pet['durum']) ?></span>
                                        </td>
                                        <td class="text-end">
                                            <?php if($pet['basvuru_durumu'] == 'Beklemede'): ?>
                                                <div class="d-inline-block text-start me-2 p-1 bg-white border rounded shadow-sm small">
                                                    <span class="text-dark d-block mb-1">👤 <strong>Aday:</strong> <?= htmlspecialchars($pet['basvuru_yapan']) ?></span>
                                                    <a href="tel:<?= htmlspecialchars($pet['basvuru_tel']) ?>" class="btn btn-sm btn-link text-success p-0 fw-bold me-2"><i class="fas fa-phone-alt"></i> <?= htmlspecialchars($pet['basvuru_tel']) ?></a>
                                                    <a href="index.php?action=updateBasvuru&id=<?= $pet['id'] ?>&status=Onaylandı" class="btn btn-sm btn-success fw-bold p-1 py-0 shadow-sm text-white text-decoration-none small" style="font-size: 11px;">Onayla</a>
                                                    <a href="index.php?action=updateBasvuru&id=<?= $pet['id'] ?>&status=Yok" class="btn btn-sm btn-danger fw-bold p-1 py-0 shadow-sm text-white text-decoration-none small" style="font-size: 11px;">Reddet</a>
                                                </div>
                                            <?php endif; ?>
                                            <a href="index.php?action=view&id=<?= $pet['id'] ?>" class="btn btn-outline-primary btn-sm fw-bold">Görüntüle</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card shadow border-0">
                        <div class="card-header bg-danger text-white fw-bold"><i class="fas fa-hands-helping me-1"></i> Ulusal Ağa Ortak Yardımlaşma İlanı Gönder</div>
                        <div class="card-body p-3">
                            <form action="index.php?action=saveYardim" method="POST">
                                <div class="mb-2">
                                    <label class="form-label small fw-bold">Çağrı Başlığı</label>
                                    <input type="text" name="baslik" class="form-control form-control-sm" placeholder="Örn: Acil Kan Aranıyor veya Cihaz İhtiyacı" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small fw-bold">İlan Türü</label>
                                    <select name="ilan_turu" class="form-select form-select-sm">
                                        <option value="Klinik İhtiyacı">Klinik Malzeme/Cihaz Desteği</option>
                                        <option value="Hasta Yardımı">Acil Hasta/Sokak Canı Yardımı</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small fw-bold">Talep ve Çağrı Detayı</label>
                                    <textarea name="detay" class="form-control form-control-sm" rows="2" placeholder="İhtiyacınızı detaylıca açıklayın..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-danger btn-sm w-100 fw-bold"><i class="fas fa-share-square me-1"></i> Tüm Veterinerlerin Ekranına Gönder</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card shadow border-0">
                        <div class="card-header bg-success text-white fw-bold"><i class="fas fa-plus-circle me-1"></i> Kliniğimize Doğrudan Hasta Kabulü</div>
                        <div class="card-body p-3">
                            <form action="index.php?action=veterinerSavePet" method="POST">
                                <div class="mb-2"><label class="form-label small fw-bold">Hayvanın Adı</label><input type="text" name="isim" class="form-control form-control-sm" required></div>
                                <div class="row">
                                    <div class="col mb-2"><label class="form-label small fw-bold">Türü</label><select name="tur" class="form-select form-select-sm"><option value="Kedi">Kedi</option><option value="Köpek">Köpek</option></select></div>
                                    <div class="col mb-2"><label class="form-label small fw-bold">Cinsi</label><input type="text" name="cins" class="form-control form-control-sm" required></div>
                                </div>
                                <div class="row">
                                    <div class="col mb-2"><label class="form-label small fw-bold">Sahibi (Boşsa Sahipsiz)</label><input type="text" name="sahibi" class="form-control form-control-sm"></div>
                                    <div class="col mb-2"><label class="form-label small fw-bold">Sahip Tel</label><input type="text" name="telefon" class="form-control form-control-sm"></div>
                                </div>
                                <div class="row">
                                    <div class="col mb-2">
                                        <label class="form-label small fw-bold">Klinik Durum</label>
                                        <select name="durum" class="form-select form-select-sm"><option value="Bekliyor">Bekliyor</option><option value="Tedavide">Tedavide</option><option value="İyi">İyi</option></select>
                                    </div>
                                    <div class="col mb-2">
                                        <label class="form-label small fw-bold">Sahiplendirme Vitrini?</label>
                                        <select name="sahiplendirme" class="form-select form-select-sm"><option value="Hayır">Hayır (Sahipli)</option><option value="Sahiplendirme İlanında">Evet (Portal Vitrinine Gönder)</option></select>
                                    </div>
                                </div>
                                <div class="mb-2"><label class="form-label small fw-bold">Şikayet Detayı</label><textarea name="belirtiler" class="form-control form-control-sm" rows="2" required></textarea></div>
                                <button type="submit" class="btn btn-success btn-sm w-100 fw-bold py-2">Bizim Kliniğe Kaydet</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>