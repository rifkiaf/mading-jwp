<?php
include('config_query.php');
$db = new database();
session_start();
$id_users = $_SESSION['id_users'];
$aksi = $_GET['aksi'];

// var_dump($id_users);
// die;

if ($aksi == "add") {
    //cek file sudah dipilih atau belum

    // echo "<pre>";
    // print_r($_FILES);
    // echo "<pre>";
    // die;

    if ($_FILES["header"]["name"] != '') {
        $tmp = explode('.', $_FILES["header"]["name"]); //memecah nama file dan extension
        $ext = end($tmp); //mengambil extension
        $filename = $tmp[0]; //mengambil nilai nama file tanpa extension
        $allowed_ext = array("jpg", "png", "jpeg"); //extension file yang diizinkan

        if (in_array($ext, $allowed_ext)) { //cek validasi extension 

            if ($_FILES['header']['size'] <= 5120000) { //cek ukuran gambar, maks 5mb 
                $name = $filename . '_' . rand() . '.' . $ext; //Rename nama file gambar
                $path = "../files/" . $name; //lokasi upload file
                $uploaded = move_uploaded_file($_FILES["header"]["tmp_name"], $path);
                $uploaded = true;//memindahkan file

                if ($uploaded) {
                    $insertData = $db->tambah_data($name, $_POST["judul_artikel"], $_POST["isi_artikel"], $_POST["status_publish"], $id_users); // query insert data

                    // var_dump($insertData);
                    // die;

                    if ($insertData) {
                        echo "<script>alert('Data berhasil ditambahkan!');document.location.href = 'index.php';</script>";
                    } else {
                        echo "<script>alert('Data gagal ditambahkan!');document.location.href = 'index.php';</script>";
                    }
                } else {
                    echo "<script>alert('Upload file gagal!');document.location.href = 'tambah_data.php';</script>";
                }
            } else {
                echo "<script>alert('Ukuran gambar lebih dari 5Mb');document.location.href = 'tambah_data.php';</script>";
            }
        } else {
            echo "<script>alert('File yang diupload bukan ekstensi yang diizinkan');document.location.href = 'tambah_data.php';</script>";
        }

    } else {
        echo "<script>alert('Pilih file gambar');document.location.href = 'tambah_data.php';</script>";
    }
} elseif ($aksi == "update") {
    $id_artikel = $_POST['id_artikel'];
    if (!empty($id_artikel)) { //cek apakah id_artikel tersedia?
        if ($_FILES['header']['name'] != '') { //cek apakah melakukan upload file

            $data = $db->get_by_id($id_artikel);

            //operasi hapus file
            if (file_exists('../files/' . $data['header']) && $data['header'])
                unlink('../files/' . $data['header']);
            $tmp = explode('.', $_FILES["header"]["name"]); //memecah nama file dan extension

            $ext = end($tmp); //mengambil extension
            $filename = $tmp[0]; //mengambil nilai nama file tanpa extension
            $allowed_ext = array("jpg", "png", "jpeg"); //extension file yang diizinkan

            if (in_array($ext, $allowed_ext)) { //cek validasi extension 

                if ($_FILES['header']['size'] <= 5120000) { //cek ukuran gambar, maks 5mb 
                    $name = $filename . '_' . rand() . '.' . $ext; //Rename nama file gambar
                    $path = "../files/" . $name; //lokasi upload file
                    $uploaded = move_uploaded_file($_FILES["header"]["tmp_name"], $path);
                    $uploaded = true;//memindahkan file

                    if ($uploaded) {
                        $updateData = $db->update_data($name, $_POST["judul_artikel"], $_POST["isi_artikel"], $_POST["status_publish"], $_POST['id_artikel'], $id_users); // query update data

                        // var_dump($updateData);
                        // die;

                        if ($updateData) {
                            echo "<script>alert('Data berhasil diubah!');document.location.href = 'index.php';</script>";
                        } else {
                            echo "<script>alert('Data gagal diubah!');document.location.href = 'index.php';</script>";
                        }
                    } else {
                        echo "<script>alert('Upload file gagal!');document.location.href = 'edit.php?=" . $id_artikel . "';</script>";
                    }
                } else {
                    echo "<script>alert('Ukuran gambar lebih dari 5Mb');document.location.href = 'edit.php?=" . $id_artikel . "';</script>";
                }
            } else {
                echo "<script>alert('File yang diupload bukan ekstensi yang diizinkan');document.location.href = 'edit.php?=" . $id_artikel . "';</script>";
            }


        } else {
            $updateData = $db->update_data('not_set', $_POST['judul_artikel'], $_POST['isi_artikel'], $_POST['status_publish'], $_POST['id_artikel'], $id_users);
            if ($updateData) {
                echo "<script>alert('Data berhasil diubah!');document.location.href = 'tambah_data.php';</script>";
            } else {
                echo "<script>alert('Data gagal diubah!');document.location.href = 'tambah_data.php';</script>";
            }
        }



    } else {
        echo "<script>alert('Anda belum memilih artikel');document.location.href = 'tambah_data.php';</script>";
    }

} elseif ($aksi == "delete") {
    $id_artikel = $_GET['id'];
    if (!empty($id_artikel)) {
        $data = $db->get_by_id($id_artikel);

        //operasi hapus file
        if (file_exists('../files/' . $data['header']) && $data['header'])
            unlink('../files/' . $data['header']);

            $deleteData = $db->delete_data($id_artikel);
            if ($deleteData) {
                echo "<script>alert('Data berhasil dihapus!');document.location.href = 'tambah_data.php';</script>";
            } else {
                echo "<script>alert('Data gagal dihapus!');document.location.href = 'tambah_data.php';</script>";
            }

    } else {
        echo "<script>alert('Anda belum memilih artikel');document.location.href = 'tambah_data.php';</script>";
    }
} else {
    echo "<script>alert('Anda tidak mendapatkan akses untuk operasi ini!');document.location.href = 'index.php';</script>";
}

?>