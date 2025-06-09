<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Diagnosis;
use App\Models\Evidence;
use App\Models\Hypothesis;
use App\Models\HypothesisImage;
use App\Models\Rule;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Add user data
        User::create([
            'name' => 'admin',
            'email' => 'payasmodel@mail.com',
            'password' => bcrypt('131705'),
            'role' => 'admin',
            // 'avatar' => 'avatar'
        ]);
        User::create([
            'name' => 'user',
            'email' => 'user@mail.com',
            'password' => bcrypt('user123'),
            'role' => 'user',
            // 'avatar' => 'avatar'
        ]);

        // Add evidence data
        Evidence::create(['code' => 'G001', 'name' => 'Gigi ngilu saat makan/minum']);
        Evidence::create(['code' => 'G002', 'name' => 'Nyeri gigi spontan']);
        Evidence::create(['code' => 'G003', 'name' => 'Gigi berlubang']);
        Evidence::create(['code' => 'G004', 'name' => 'Gusi berdarah']);
        Evidence::create(['code' => 'G005', 'name' => 'Gigi bergoyang']);
        Evidence::create(['code' => 'G006', 'name' => 'Gusi bengkak']);
        Evidence::create(['code' => 'G007', 'name' => 'Sakit kepala']);
        
        // Add hypothesis data
        Hypothesis::create(['code' => 'P001', 'name' => 'Karies Gigi', 'description' => 'Karies gigi adalah kerusakan pada jaringan keras gigi akibat aktivitas bakteri yang menghasilkan asam dari sisa makanan, terutama gula.', 'solution' => 'Restorasi gigi(penambalan)']);
        Hypothesis::create(['code' => 'P002', 'name' => 'Periodontitis', 'description' => 'Periodontitis adalah infeksi serius pada gusi yang merusak jaringan lunak dan tulang penyangga gigi.', 'solution' => 'Scalling, Root planing, Splinting']); 
        Hypothesis::create(['code' => 'P003', 'name' => 'Gingivitis', 'description' => 'Gingivitis adalah peradangan pada gusi yang ditandai dengan kemerahan, pembengkakan, dan perdarahan saat menyikat gigi.', 'solution' => 'Scalling, Root planing']);
        Hypothesis::create(['code' => 'P004', 'name' => 'Abses Gigi', 'description' => 'Abses gigi adalah kumpulan nanah yang terbentuk akibat infeksi bakteri di dalam gigi atau gusi.', 'solution' => 'Trepanasi, Perawatan saluran akar']);
        Hypothesis::create(['code' => 'P005', 'name' => 'Pulpitis', 'description' => 'Pulpitis adalah peradangan pada pulpa gigi, yaitu jaringan lunak di dalam gigi yang mengandung saraf dan pembuluh darah. ', 'solution' => 'Perawatan saluran akar']);

        // Add data gambar hypotesis
        HypothesisImage::create(['hypothesis_id' => 1, 'image_path' => 'Karies.png']);
        HypothesisImage::create(['hypothesis_id' => 2, 'image_path' => 'Periodontitis.png']);
        HypothesisImage::create(['hypothesis_id' => 3, 'image_path' => 'Gingivitis.png']);
        HypothesisImage::create(['hypothesis_id' => 4, 'image_path' => 'Abses.png']);
        HypothesisImage::create(['hypothesis_id' => 5, 'image_path' => 'Pulpitis.png']);


        // Add diagnosis data
        // Diagnosis::create(['hypothesis_id' => 1, 'name' => 'jonathan', 'description' => 'pasien', 'value' => rand(50, 100) * 0.01]);
        // Diagnosis::create(['hypothesis_id' => 1, 'name' => 'zeppeli', 'description' => 'pasien', 'value' => rand(50, 100) * 0.01]);
        // Diagnosis::create(['hypothesis_id' => 1, 'name' => 'erina', 'description' => 'pasien', 'value' => rand(50, 100) * 0.01]);
        // Diagnosis::create(['hypothesis_id' => 1, 'name' => 'dio', 'description' => 'pasien', 'value' => rand(50, 100) * 0.01]);
        // Diagnosis::create(['hypothesis_id' => 1, 'name' => 'speedwagon', 'description' => 'pasien', 'value' => rand(50, 100) * 0.01]);
        // Diagnosis::create(['hypothesis_id' => 2, 'name' => 'joseph', 'description' => 'pasien', 'value' => rand(50, 100) * 0.01]);
        // Diagnosis::create(['hypothesis_id' => 2, 'name' => 'cecar', 'description' => 'pasien', 'value' => rand(50, 100) * 0.01]);
        // Diagnosis::create(['hypothesis_id' => 2, 'name' => 'lisa', 'description' => 'pasien', 'value' => rand(50, 100) * 0.01]);
        // Diagnosis::create(['hypothesis_id' => 2, 'name' => 'jotaro', 'description' => 'pasien', 'value' => rand(50, 100) * 0.01]);
        // Diagnosis::create(['hypothesis_id' => 2, 'name' => 'kakyoin', 'description' => 'pasien', 'value' => rand(50, 100) * 0.01]);
        // Diagnosis::create(['hypothesis_id' => 2, 'name' => 'avdol', 'description' => 'pasien', 'value' => rand(50, 100) * 0.01]);
        // Diagnosis::create(['hypothesis_id' => 3, 'name' => 'polnaref', 'description' => 'pasien', 'value' => rand(50, 100) * 0.01]);
        // Diagnosis::create(['hypothesis_id' => 3, 'name' => 'josuke', 'description' => 'pasien', 'value' => rand(50, 100) * 0.01]);
        // Diagnosis::create(['hypothesis_id' => 3, 'name' => 'okuyasu', 'description' => 'pasien', 'value' => rand(50, 100) * 0.01]);
        // Diagnosis::create(['hypothesis_id' => 3, 'name' => 'koichi', 'description' => 'pasien', 'value' => rand(50, 100) * 0.01]);
        // Diagnosis::create(['hypothesis_id' => 3, 'name' => 'rohan', 'description' => 'pasien', 'value' => rand(50, 100) * 0.01]);
        // Diagnosis::create(['hypothesis_id' => 3, 'name' => 'giorno', 'description' => 'pasien', 'value' => rand(50, 100) * 0.01]);
        // Diagnosis::create(['hypothesis_id' => 4, 'name' => 'bucalati', 'description' => 'pasien', 'value' => rand(50, 100) * 0.01]);
        // Diagnosis::create(['hypothesis_id' => 4, 'name' => 'mista', 'description' => 'pasien', 'value' => rand(50, 100) * 0.01]);
        // Diagnosis::create(['hypothesis_id' => 4, 'name' => 'fugo', 'description' => 'pasien', 'value' => rand(50, 100) * 0.01]);
        // Diagnosis::create(['hypothesis_id' => 4, 'name' => 'narancia', 'description' => 'pasien', 'value' => rand(50, 100) * 0.01]);
        // Diagnosis::create(['hypothesis_id' => 4, 'name' => 'abacio', 'description' => 'pasien', 'value' => rand(50, 100) * 0.01]);
        // Diagnosis::create(['hypothesis_id' => 4, 'name' => 'jolyne', 'description' => 'pasien', 'value' => rand(50, 100) * 0.01]);
        // Diagnosis::create(['hypothesis_id' => 4, 'name' => 'ermes', 'description' => 'pasien', 'value' => rand(50, 100) * 0.01]);
        // Add rule data
        Rule::create(['evidence_id' => 1, 'hypothesis_id' => 1, 'weight' => 0.56]);
        Rule::create(['evidence_id' => 2, 'hypothesis_id' => 1, 'weight' => 0]);
        Rule::create(['evidence_id' => 3, 'hypothesis_id' => 1, 'weight' => 1]);
        Rule::create(['evidence_id' => 4, 'hypothesis_id' => 1, 'weight' => 0]);
        Rule::create(['evidence_id' => 5, 'hypothesis_id' => 1, 'weight' => 0]);
        Rule::create(['evidence_id' => 6, 'hypothesis_id' => 1, 'weight' => 0]);
        Rule::create(['evidence_id' => 7, 'hypothesis_id' => 1, 'weight' => 0]);

        Rule::create(['evidence_id' => 1, 'hypothesis_id' => 2, 'weight' => 1]);
        Rule::create(['evidence_id' => 2, 'hypothesis_id' => 2, 'weight' => 0.22]);
        Rule::create(['evidence_id' => 3, 'hypothesis_id' => 2, 'weight' => 0.11]);
        Rule::create(['evidence_id' => 4, 'hypothesis_id' => 2, 'weight' => 0]);
        Rule::create(['evidence_id' => 5, 'hypothesis_id' => 2, 'weight' => 0.33]);
        Rule::create(['evidence_id' => 6, 'hypothesis_id' => 2, 'weight' => 0]);
        Rule::create(['evidence_id' => 7, 'hypothesis_id' => 2, 'weight' => 0]);

        Rule::create(['evidence_id' => 1, 'hypothesis_id' => 3, 'weight' => 0.36]);
        Rule::create(['evidence_id' => 2, 'hypothesis_id' => 3, 'weight' => 0]);
        Rule::create(['evidence_id' => 3, 'hypothesis_id' => 3, 'weight' => 0.18]);
        Rule::create(['evidence_id' => 4, 'hypothesis_id' => 3, 'weight' => 0.14]);
        Rule::create(['evidence_id' => 5, 'hypothesis_id' => 3, 'weight' => 0]);
        Rule::create(['evidence_id' => 6, 'hypothesis_id' => 3, 'weight' => 0.18]);
        Rule::create(['evidence_id' => 7, 'hypothesis_id' => 3, 'weight' => 0]);

        Rule::create(['evidence_id' => 1, 'hypothesis_id' => 4, 'weight' => 0.45]);
        Rule::create(['evidence_id' => 2, 'hypothesis_id' => 4, 'weight' => 0.42]);
        Rule::create(['evidence_id' => 3, 'hypothesis_id' => 4, 'weight' => 1]);
        Rule::create(['evidence_id' => 4, 'hypothesis_id' => 4, 'weight' => 0.06]);
        Rule::create(['evidence_id' => 5, 'hypothesis_id' => 4, 'weight' => 0.09]);
        Rule::create(['evidence_id' => 6, 'hypothesis_id' => 4, 'weight' => 0.27]);
        Rule::create(['evidence_id' => 7, 'hypothesis_id' => 4, 'weight' => 0.06]);

        Rule::create(['evidence_id' => 1, 'hypothesis_id' => 5, 'weight' => 0.65]);
        Rule::create(['evidence_id' => 2, 'hypothesis_id' => 5, 'weight' => 0.41]);
        Rule::create(['evidence_id' => 3, 'hypothesis_id' => 5, 'weight' => 1]);
        Rule::create(['evidence_id' => 4, 'hypothesis_id' => 5, 'weight' => 0]);
        Rule::create(['evidence_id' => 5, 'hypothesis_id' => 5, 'weight' => 0]);
        Rule::create(['evidence_id' => 6, 'hypothesis_id' => 5, 'weight' => 0.01]);
        Rule::create(['evidence_id' => 7, 'hypothesis_id' => 5, 'weight' => 0.12]);

        // Add Setting data
        Setting::create(['component' => 'title', 'value' => 'Sistem Pakar Penyakit']);
        Setting::create(['component' => 'description', 'value' => '
            Sistem pakar adalah sistem komputer yang dirancang untuk menyelesaikan masalah atau memberikan solusi yang rumit dengan cara mengaplikasikan pengetahuan dari seorang ahli dalam bidang tertentu. Sistem pakar memanfaatkan berbagai macam metode untuk menghasilkan solusi yang tepat dan efektif. Salah satu metode yang sering digunakan dalam sistem pakar adalah metode teorema Bayes.
            Metode teorema Bayes digunakan untuk menghitung probabilitas kejadian suatu peristiwa berdasarkan kondisi awal atau informasi sebelumnya. Dalam sistem pakar, teorema Bayes digunakan untuk mengambil keputusan atau memberikan rekomendasi dengan mempertimbangkan informasi awal atau kondisi sebelumnya.
            Contoh penerapan metode teorema Bayes dalam sistem pakar adalah dalam bidang kesehatan. Seorang ahli medis dapat memanfaatkan metode ini untuk mendiagnosis suatu penyakit berdasarkan gejala dan kondisi pasien. Dalam hal ini, informasi awal atau kondisi sebelumnya adalah gejala yang dialami oleh pasien, sedangkan kejadian yang ingin diketahui probabilitasnya adalah apakah pasien tersebut menderita penyakit tertentu atau tidak.
        ']);
        Setting::create(['component' => 'evidence', 'value' => 'Gejala']);
        Setting::create(['component' => 'hypothesis', 'value' => 'Penyakit']);
    }
}
