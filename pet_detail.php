<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Detayli Tibbi Klinik Analiz Raporu</title>
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
            <h4 class="fw-bold text-primary mb-4"><i class="fas fa-paw"></i> VET-MVC</h4>
            <?php if($_SESSION['role'] === 'admin'): ?>
                <div class="badge bg-danger p-2 mb-4 w-100">YETKİ: VETERİNER</div>
                <ul class="nav flex-column gap-2"><li class="nav-item"><a class="nav-link text-white active-menu" href="index.php?action=list"><i class="fas fa-arrow-left me-2"></i> Geri Dön</a></li></ul>
            <?php else: ?>
                <div class="badge bg-info text-dark p-2 mb-3 w-100">YETKİ: HASTA SAHİBİ</div>
                
                <div class="fw-bold text-secondary small mb-2 mt-2 border-top pt-2"><i class="fas fa-list"></i> Hayvanlarım</div>
                <ul class="nav flex-column gap-1 mb-4">
                    <?php foreach($otherPets as $op): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white p-1 small <?= $op['id'] == $pet['id'] ? 'fw-bold text-primary' : '' ?>" href="index.php?action=view&id=<?= $op['id'] ?>">
                                🐾 <?= htmlspecialchars($op['isim']) ?> (<?= htmlspecialchars($op['tur']) ?>)
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <ul class="nav flex-column gap-2"><li class="nav-item"><a class="nav-link text-white" href="index.php?action=logout"><i class="fas fa-sign-out-alt me-2"></i> Güvenli Çıkış</a></li></ul>
            <?php endif; ?>
        </div>

        <div class="col-md-10 main-content">
            <?php if($pet['sahiplendirme'] == 'Sahiplendirme İlanında'): ?>
                <div class="alert alert-purple text-white p-4 rounded mb-4 shadow-sm" style="background-color: #6f42c1;">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="fw-bold mb-1"><i class="fas fa-heart me-2"></i> Beni Sahiplenmek İster Misiniz?</h4>
                            <p class="mb-0">Şu anda koruma altında olduğum klinik: <strong class="text-warning text-uppercase"><?= htmlspecialchars($pet['klinik_adi']) ?></strong>. Tüm tıbbi tedavi geçmişimi aşağıdan inceleyebilirsiniz.</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <button class="btn btn-light fw-bold p-3 px-4 shadow-sm" style="color: #6f42c1;" onclick="alert('Sahiplenme talebiniz iletilmiştir!')">
                                <i class="fas fa-hand-holding-heart text-danger me-1"></i> ŞİMDİ SAHİPLEN
                            </button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow border-0 mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <h4 class="mb-0 fw-bold"><i class="fas fa-file-medical-alt me-2"></i> Tibbi Klinik Analiz ve Recete Raporu</h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="row border-bottom pb-3 mb-4">
                                <div class="col-md-6">
                                    <h3>Hasta Adı: <span class="text-primary fw-bold text-uppercase"><?= htmlspecialchars($pet['isim']) ?></span></h3>
                                    <p class="text-muted mb-0">Türü/Cinsi: <?= htmlspecialchars($pet['tur']) ?> (<?= htmlspecialchars($pet['cins']) ?>)</p>
                                    <small class="text-muted">Sorumlu Klinik: <strong><?= htmlspecialchars($pet['klinik_adi'] ?? 'Genel Merkez') ?></strong></small>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <h4>Hasta Sahibi: <span class="fw-bold text-secondary"><?= htmlspecialchars($pet['sahibi']) ?></span></h4>
                                    <span class="badge bg-danger fs-6 px-3 py-2">Klinik Durum: <?= htmlspecialchars($pet['durum']) ?></span>
                                </div>
                            </div>

                            <h5 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="fas fa-microscope text-success me-2"></i> Klinik Test Sonuçları</h5>
                            <div class="row g-3 mb-4">
                                <div class="col-md-4"><div class="p-3 bg-white border rounded shadow-sm text-center"><small class="text-muted d-block fw-bold mb-1">RÖNTGEN</small><span class="fw-bold text-dark"><i class="fas fa-x-ray text-info me-1"></i> <?= htmlspecialchars($pet['rontgen'] ?? 'Çekilmedi') ?></span></div></div>
                                <div class="col-md-4"><div class="p-3 bg-white border rounded shadow-sm text-center"><small class="text-muted d-block fw-bold mb-1">KAN TAHLİLİ</small><span class="fw-bold text-dark"><i class="fas fa-vial text-danger me-1"></i> <?= htmlspecialchars($pet['kan_tahlili'] ?? 'Yapılmadı') ?></span></div></div>
                                <div class="col-md-4"><div class="p-3 bg-white border rounded shadow-sm text-center"><small class="text-muted d-block fw-bold mb-1">İĞNE / SERUM</small><span class="fw-bold text-dark"><i class="fas fa-syringe text-warning me-1"></i> <?= htmlspecialchars($pet['igne_serum'] ?? 'Uygulanmadı') ?></span></div></div>
                            </div>

                            <div class="mb-3"><h5 class="fw-bold text-dark">Şikayet ve Belirtiler</h5><div class="alert alert-secondary"><?= nl2br(htmlspecialchars($pet['belirtiler'] ?? '')) ?></div></div>
                            <div class="mb-3"><h5 class="fw-bold text-dark">Uygulanan Tedavi</h5><div class="alert alert-success"><?= nl2br(htmlspecialchars($pet['tedavi'] ?? '')) ?></div></div>
                            <div class="mb-3"><h5 class="fw-bold text-dark">Hekim Reçetesi</h5><div class="alert alert-warning fw-bold text-dark"><i class="fas fa-pills me-1"></i> <?= nl2br(htmlspecialchars($pet['recete'] ?? '')) ?></div></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    
                    <?php if($_SESSION['role'] === 'customer'): ?>
                    <div class="card shadow border-0 mb-4">
                        <div class="card-header bg-success text-white fw-bold"><i class="fas fa-plus-circle me-1"></i> Yeni Evcil Hayvan Ekle</div>
                        <div class="card-body p-3">
                            <p class="small text-muted mb-3">Hesabınıza kayıtlı ikinci bir kedi/köpek varsa bilgilerini girerek kliniğinize gönderebilirsiniz.</p>
                            <form action="index.php?action=customerSavePet" method="POST">
                                <div class="mb-2">
                                    <label class="form-label small fw-bold text-secondary">Hayvanın Adı</label>
                                    <input type="text" name="isim" class="form-control form-control-sm bg-light border-0" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small fw-bold text-secondary">Türü</label>
                                    <select name="tur" class="form-select form-select-sm bg-light border-0">
                                        <option value="Kedi">Kedi</option>
                                        <option value="Köpek">Köpek</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-secondary">Cinsi</label>
                                    <input type="text" name="cins" class="form-control form-control-sm bg-light border-0" placeholder="Örn: Siyam" required>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm w-100 fw-bold py-2 shadow-sm"><i class="fas fa-save me-1"></i> Hayvanı Hesabıma Ekle</button>
                            </form>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if($_SESSION['role'] === 'admin'): ?>
                    <div class="card shadow border-0">
                        <div class="card-header bg-dark text-white fw-bold py-3"><i class="fas fa-edit me-2"></i> Klinik Raporu Düzenle</div>
                        <div class="card-body p-3">
                            <form action="index.php?action=saveReport" method="POST">
                                <input type="hidden" name="id" value="<?= $pet['id'] ?>">
                                <div class="mb-2"><label class="form-label small fw-bold">Klinik Durum</label><select name="durum" class="form-select form-select-sm"><option value="Bekliyor" <?= $pet['durum'] == 'Bekliyor' ? 'selected' : '' ?>>Bekliyor</option><option value="Tedavide" <?= $pet['durum'] == 'Tedavide' ? 'selected' : '' ?>>Tedavide</option><option value="İyi" <?= $pet['durum'] == 'İyi' ? 'selected' : '' ?>>İyi</option></select></div>
                                <div class="mb-2"><label class="form-label small fw-bold">Röntgen</label><input type="text" name="rontgen" class="form-control form-control-sm" value="<?= htmlspecialchars($pet['rontgen'] ?? '') ?>"></div>
                                <div class="mb-2"><label class="form-label small fw-bold">Kan Tahlili</label><input type="text" name="kan_tahlili" class="form-control form-control-sm" value="<?= htmlspecialchars($pet['kan_tahlili'] ?? '') ?>"></div>
                                <div class="mb-2"><label class="form-label small fw-bold">İğne / Serum</label><input type="text" name="igne_serum" class="form-control form-control-sm" value="<?= htmlspecialchars($pet['igne_serum'] ?? '') ?>"></div>
                                <div class="mb-2"><label class="form-label small fw-bold">Reçete</label><input type="text" name="recete" class="form-control form-control-sm" value="<?= htmlspecialchars($pet['recete'] ?? '') ?>"></div>
                                <div class="mb-2"><label class="form-label small fw-bold">Belirtiler</label><textarea name="belirtiler" class="form-control form-control-sm" rows="2"><?= htmlspecialchars($pet['belirtiler'] ?? '') ?></textarea></div>
                                <div class="mb-3"><label class="form-label small fw-bold">Tedavi Detayı</label><textarea name="tedavi" class="form-control form-control-sm" rows="2"><?= htmlspecialchars($pet['tedavi'] ?? '') ?></textarea></div>
                                <button type="submit" class="btn btn-success btn-sm w-100 fw-bold py-2">Raporu Güncelle</button>
                            </form>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</div>
</body>
</html>