<?php
include("template/header.php");
include("admin/config_query.php");
$db = new database();
$id_artikel = $_GET['id'];
if(!empty($id_artikel)) {
    $data = $db->get_by_id($id_artikel);
    if(empty($data)) {
        echo "<script>alert('Id artikel tidak ditemukan');document.location.href='index.php'</script>";
    } elseif($data['status_publish']!=='publish') {
      echo "<script>alert('Artikel yang anda pilih belum tersedia!');document.location.href='index.php'</script>";
    }
    
} else {
    echo "<script>alert('Anda belum memilih artikel');document.location.href='index.php'</script>";
}

?>
  <div class="site-cover site-cover-sm same-height overlay single-page" style="background-image: url('files/<?= $data['header'];?>');">
    <div class="container">
      <div class="row same-height justify-content-center">
        <div class="col-md-6">
          <div class="post-entry text-center">
            <h1 class="mb-4"><?= $data['judul_artikel'];?></h1>
            <div class="post-meta align-items-center text-center">
              <figure class="author-figure mb-0 me-3 d-inline-block"><img src="assets/landing/images/person_1.jpg" alt="Image" class="img-fluid"></figure>
              <span class="d-inline-block mt-1">By <?= $data['name'];?></span>
              <span>&nbsp;-&nbsp; <?php
									if ($data['updated_at'] == '') {
										echo date('d M y', strtotime($data['created_at']));
									} else {
										echo date('d M y', strtotime($data['updated_at']));
									}
									?></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <section class="section">
    <div class="container">

      <div class="row blog-entries element-animate">

        <div class="col-md-12 col-lg-12 main-content">

          <div class="post-content-body">
            <?= $data['isi_artikel']?>
          </div>


         
  </section>



  <!-- End posts-entry -->

<?php
include("template/footer.php")
?>