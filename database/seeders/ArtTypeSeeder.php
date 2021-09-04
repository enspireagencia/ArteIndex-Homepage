<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\ArtType;
class ArtTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $aty_types = ['Book', 'Ceramics', 'Collage', 'Digital', 'Drawing','Fiber','Film/Video','Furniture','Garment','Glass','Illustration','Installation','Jewelry','Mask','Metalworks','Mixed Media','Mosaic','Mural','New Media','Other','Painting','Performance','Photography','Print','Sculpture','Textile','Wood','Works on Paper'];
        foreach ($aty_types as $key => $aty_type) {
            ArtType::updateOrCreate([
                'name' => $aty_type,
            ]);
        }
    }
}
