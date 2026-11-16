<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0"><?= esc($judul) ?></h4>
  <a href="<?= site_url($uri . '/baru') ?>" class="btn btn-primary">+ Tambah</a>
</div>
<div class="card"><div class="card-body">
  <table class="table table-striped align-middle datatable">
    <thead><tr><th>#</th><?php foreach ($kolom as $label): ?><th><?= esc($label) ?></th><?php endforeach ?><th></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $i => $r): ?>
      <tr>
        <td><?= $i + 1 ?></td>
        <?php foreach (array_keys($kolom) as $k): ?><td><?= esc($r[$k] ?? '') ?></td><?php endforeach ?>
        <td class="text-end text-nowrap">
          <a class="btn btn-sm btn-outline-secondary" href="<?= site_url("{$uri}/ubah/{$r['id']}") ?>">Ubah</a>
          <form method="post" action="<?= site_url("{$uri}/hapus/{$r['id']}") ?>" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
            <?= csrf_field() ?><button class="btn btn-sm btn-outline-danger">Hapus</button>
          </form>
        </td>
      </tr>
    <?php endforeach ?>
    </tbody>
  </table>
</div></div>
<?= $this->endSection() ?>
