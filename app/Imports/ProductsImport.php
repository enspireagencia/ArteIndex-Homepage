<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
class ProductsImport implements ToCollection,WithStartRow
{
    private $cnt = 0;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $products = Product::where('linnaeus_name',$row[0])->first();
            if(isset($products)){
                ++$this->cnt;
                $products->update([
                    'supplier' =>$row[2],
                    'actual_stock' => $row[3],
                ]);
            }
        }
        return $products;
    }
    public function getRowCount(): int
    {
        return $this->cnt;
    }
    public function startRow(): int
    {
        return 3;
    }
}
