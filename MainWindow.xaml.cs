using System;
using System.Windows;
using System.Windows.Controls;

namespace StudentRegistrationWPF
{
    public partial class MainWindow : Window
    {
        public MainWindow()
        {
            InitializeComponent();
        }

        private void BtnDaftar_Click(object sender, RoutedEventArgs e)
        {
            // 1. Ambil data dari inputan
            string nama = txtNama.Text.Trim();
            string nrp = txtNrp.Text.Trim();
            string departemen = ((ComboBoxItem)cmbDepartemen.SelectedItem).Content.ToString();

            // Format tanggal lahir (cek apakah sudah diisi)
            string tanggalLahir = dpTanggalLahir.SelectedDate.HasValue
                ? dpTanggalLahir.SelectedDate.Value.ToString("dd MMMM yyyy")
                : "Belum diisi";

            // Tentukan jalur masuk dari RadioButton
            string jalur = "";
            if (rbSNBP.IsChecked == true) jalur = "SNBP";
            else if (rbSNBT.IsChecked == true) jalur = "SNBT";
            else if (rbMandiri.IsChecked == true) jalur = "Mandiri";

            // 2. Validasi sederhana: pastikan Nama dan NRP tidak kosong
            if (string.IsNullOrEmpty(nama) || string.IsNullOrEmpty(nrp))
            {
                MessageBox.Show("Nama dan NRP wajib diisi!", "Peringatan", MessageBoxButton.OK, MessageBoxImage.Warning);
                return;
            }

            // 3. Rangkai teks untuk ditampilkan di ListBox
            string dataMahasiswa = $"[{jalur}] {nama} ({nrp})\nDepartemen: {departemen}\nTgl Lahir: {tanggalLahir}\n----------------------------------";

            // 4. Tambahkan ke ListBox
            lstMahasiswa.Items.Add(dataMahasiswa);

            // 5. Kosongkan form otomatis setelah mendaftar
            BersihkanForm();
        }

        private void BtnClear_Click(object sender, RoutedEventArgs e)
        {
            BersihkanForm();
        }

        private void BersihkanForm()
        {
            txtNama.Clear();
            txtNrp.Clear();
            cmbDepartemen.SelectedIndex = 0; // Kembalikan ke Teknik Informatika
            dpTanggalLahir.SelectedDate = null;
            rbSNBP.IsChecked = true;
            txtNama.Focus(); // Kembalikan kursor ke kolom nama
        }
    }
}
