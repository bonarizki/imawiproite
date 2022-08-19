<?php

namespace App\Model\Koperasi;

use Illuminate\Database\Eloquent\Model;
use App\Model\Koperasi\ProductSetting;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $connection = 'star';
    protected $table = 'product_views';
    protected $primaryKey = 'product_id';
    protected $guarded = [];

    public function ProductSetting()
    {
        return $this->hasOne(ProductSetting::class, 'product_code', 'product_code');
    }

    public static function getProductSkincare($request = null)
    {
        $query = DB::connection('star')
            ->table('mst_main_product_brand_group AS brand_group')
            ->select(
                'product.id AS product_id',
                'product.product_code AS product_code',
                'product.product_sap_code AS product_sap_code',
                'product.product_barcode AS product_barcode',
                'product.product_dozen_box_barcode AS product_dozen_box_barcode',
                'product.product_outer_box_barcode AS product_outer_box_barcode',
                'product.product_name AS product_name',
                'product.product_volume AS product_volume',
                'product.product_size AS product_size',
                'product.product_image_1 AS product_image_1',
                'product.product_image_2 AS product_image_2',
                'product.product_image_3 AS product_image_3',
                'product.product_image_4 AS product_image_4',
                'product.product_status AS product_status',
                'brand_group.id AS brand_group_id',
                'brand_group.brand_group_name AS brand_group_name',
                'brand_group.brand_group_rank AS brand_group_rank',
                'brand_group.brand_group_status AS brand_group_status',
                'brand.id AS brand_id',
                'brand.brand_code AS brand_code',
                'brand.brand_cost_center AS brand_cost_center',
                'brand.brand_cost_center_2 AS brand_cost_center_2',
                'brand.brand_profit_center AS brand_profit_center',
                'brand.brand_name AS brand_name',
                'brand.brand_rank AS brand_rank',
                'brand.brand_status AS brand_status',
                'category.id AS category_id',
                'category.category_name AS category_name',
                'category.category_rank AS category_rank',
                'category.category_status AS category_status',
                'category_sub.id AS category_sub_id',
                'category_sub.category_sub_name AS category_sub_name',
                'category_sub.category_sub_rank AS category_sub_rank',
                'category_sub.category_sub_status AS category_sub_status',
                'variant.id AS variant_id',
                'variant.variant_name AS variant_name',
                'variant.variant_rank AS variant_rank',
                'variant.variant_status AS variant_status',
                'Prange.id AS range_id',
                'Prange.range_name AS range_name',
                'Prange.range_rank AS range_rank',
                'Prange.range_status AS range_status',
                'business.id AS business_id',
                'business.business_name AS business_name',
                'price.id AS price_id',
                'price.product_price_start AS product_price_start',
                'price.product_price_rbp AS product_price_rbp',
                'price.product_price_mt AS product_price_mt',
                'price.product_price_gt AS product_price_gt',
                'price.product_price_gt_11 AS product_price_gt_11',
                'price.product_price_mbs AS product_price_mbs',
                'price.product_price_sp AS product_price_sp',
                'price.product_price_koperasi AS product_price_koperasi'
            )
            ->join('mst_main_product_brand AS brand', 'brand.brand_group_id', '=', 'brand_group.id')
            ->join('mst_main_product AS product', 'product.brand_id', '=', 'brand.id')
            ->join('mst_main_product_category AS category', 'category.id', '=', 'product.category_id')
            ->join('mst_main_product_category_sub AS category_sub', 'category_sub.id', '=', 'product.category_sub_id')
            ->join('mst_main_product_variant AS variant', 'variant.id', '=', 'product.variant_id')
            ->join('mst_main_product_range AS Prange', 'Prange.id', '=', 'product.range_id')
            ->join('mst_main_business AS business', 'business.id', '=', 'product.business_id')
            ->join(
                DB::raw(
                    '                    
                (
                    SELECT
                        `mst_main_product_price`.`id` AS `id`,
                        `mst_main_product_price`.`product_id` AS `product_id`,
                        `mst_main_product_price`.`product_price_start` AS `product_price_start`,
                        round( `mst_main_product_price`.`product_price_rbp`, 2 ) AS `product_price_rbp`,
                        round( `mst_main_product_price`.`product_price_mt`, 2 ) AS `product_price_mt`,
                        round( `mst_main_product_price`.`product_price_gt`, 2 ) AS `product_price_gt`,
                        round( `mst_main_product_price`.`product_price_mbs`, 2 ) AS `product_price_mbs`,
                        round( `mst_main_product_price`.`product_price_sp`, 2 ) AS `product_price_sp`,
                        round( `mst_main_product_price`.`product_price_gt_11`, 2 ) AS `product_price_gt_11`,
                        round( `mst_main_product_price`.`product_price_koperasi`, 2 ) AS `product_price_koperasi` 
                    FROM
                        (
                            `mst_main_product_price`
                            LEFT JOIN `mst_main_product_price` `price_temp` ON (((
                                        `mst_main_product_price`.`product_id` = `price_temp`.`product_id` 
                                        ) 
                                    AND ( `price_temp`.`deleted_at` IS NULL ) 
                                    AND ((
                                            `mst_main_product_price`.`product_price_start` < `price_temp`.`product_price_start` 
                                            ) 
                                        OR ((
                                                `mst_main_product_price`.`product_price_start` = `price_temp`.`product_price_start` 
                                                ) 
                                        AND ( `mst_main_product_price`.`id` < `price_temp`.`id` )))))) 
                    WHERE
                        ((
                                `price_temp`.`id` IS NULL 
                                ) 
                            AND ( `mst_main_product_price`.`deleted_at` IS NULL ))) AS price'
                ),
                function ($join) {
                    $join->on('price.product_id', '=', 'product.id');
                }
            )
            ->where('product.business_id', 2);

        return $query;
    }

    public static function selectField()
    {
        return [
            'product_id',
            'product_code',
            'product_sap_code',
            'product_barcode',
            'product_dozen_box_barcode',
            'product_outer_box_barcode',
            'product_name',
            'product_volume',
            'product_size',
            'product_image_1',
            'product_image_2',
            'product_image_3',
            'product_image_4',
            'product_status',
            'brand_group_id',
            'brand_group_name',
            'brand_group_rank',
            'brand_group_status',
            'brand_id',
            'brand_code',
            'brand_cost_center',
            'brand_cost_center_2',
            'brand_profit_center',
            'brand_name',
            'brand_rank',
            'brand_status',
            'category_id',
            'category_name',
            'category_rank',
            'category_status',
            'category_sub_id',
            'category_sub_name',
            'category_sub_rank',
            'category_sub_status',
            'variant_id',
            'variant_name',
            'variant_rank',
            'variant_status',
            'range_id',
            'range_name',
            'range_rank',
            'range_status',
            'business_id',
            'business_name',
            'price_id',
            'product_price_start',
            'product_price_rbp',
            'product_price_mt',
            'product_price_gt',
            'product_price_gt_11',
            'product_price_mbs',
            'product_price_sp',
            'product_price_koperasi'
        ];
    }
}
