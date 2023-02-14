<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index() {
        $products = DB::table('products_master')->paginate(10);

        return view('products.index', compact('products'));
    }

    public function show($slug) {
        $product = DB::table('products_master')
            ->where('products_master.slug', '=', $slug)
            ->first();

        $product_variants = DB::table('product_variants')
            ->where('product_code', '=', $product->product_code)
            ->get();

        return view('products.show', compact('product', 'product_variants'));
    }

    public function getConfigurations($code) {
        $configurations = [];
        $product = DB::table('product_packaging_details')
            ->join('package_types', 'product_packaging_details.micro_unit_code', '=', 'package_types.package_code')
            ->where('product_packaging_details.product_variant_code', '=', $code)
            ->select(['package_types.package_name as name', 'product_packaging_details.micro_unit_code', 'product_packaging_details.macro_unit_code', 'product_packaging_details.super_unit_code'])
            ->first();
        $product->code = 'Micro Unit';
        $configurations[] = $product;
        if (!is_null($product->micro_unit_code)) {
            $configuration = DB::table('product_packaging_details')
                ->join('package_types', 'product_packaging_details.unit_code', '=', 'package_types.package_code')
                ->where('product_packaging_details.product_variant_code', '=', $code)
                ->select(['package_types.package_name as name', 'product_packaging_details.micro_to_unit_value as value'])
                ->first();
            $configuration->code = 'Unit';
            $configurations[] = $configuration;
        }

        if (!is_null($product->macro_unit_code)) {
            $configuration = DB::table('product_packaging_details')
                ->join('package_types', 'product_packaging_details.macro_unit_code', '=', 'package_types.package_code')
                ->where('product_packaging_details.product_variant_code', '=', $code)
                ->select(['package_types.package_name as name', 'product_packaging_details.unit_to_macro_value as value'])
                ->first();
            $configuration->code = 'Macro';
            $configurations[] = $configuration;
        }

        if (!is_null($product->super_unit_code)) {
            $configuration = DB::table('product_packaging_details')
                ->join('package_types', 'product_packaging_details.super_unit_code', '=', 'package_types.package_code')
                ->where('product_packaging_details.product_variant_code', '=', $code)
                ->select(['package_types.package_name as name', 'product_packaging_details.super_unit_code as super', 'product_packaging_details.macro_to_super_value as value'])
                ->first();
            $configuration->code = 'Super';
            $configurations[] = $configuration;
        }

        return response()->json(['msg' => 'success', 'data' => $configurations ]);
    }

    public function getProductConfigurations($product_code) {
        $configurations = [];
        $product = DB::table('product_packaging_details')
            ->join('package_types', 'product_packaging_details.micro_unit_code', '=', 'package_types.package_code')
            ->where('product_packaging_details.product_code', '=', $product_code)
            ->select(['package_types.package_name as name', 'product_packaging_details.micro_unit_code', 'product_packaging_details.macro_unit_code', 'product_packaging_details.super_unit_code'])
            ->first();
        $product->code = 'Micro Unit';
        $configurations[] = $product;
        if (!is_null($product->micro_unit_code)) {
            $configuration = DB::table('product_packaging_details')
                ->join('package_types', 'product_packaging_details.unit_code', '=', 'package_types.package_code')
                ->where('product_packaging_details.product_code', '=', $product_code)
                ->select(['package_types.package_name as name', 'product_packaging_details.micro_to_unit_value as value'])
                ->first();
            $configuration->code = 'Unit';
            $configurations[] = $configuration;
        }

        if (!is_null($product->macro_unit_code)) {
            $configuration = DB::table('product_packaging_details')
                ->join('package_types', 'product_packaging_details.macro_unit_code', '=', 'package_types.package_code')
                ->where('product_packaging_details.product_code', '=', $product_code)
                ->select(['package_types.package_name as name', 'product_packaging_details.unit_to_macro_value as value'])
                ->first();
            $configuration->code = 'Macro';
            $configurations[] = $configuration;
        }

        if (!is_null($product->super_unit_code)) {
            $configuration = DB::table('product_packaging_details')
                ->join('package_types', 'product_packaging_details.super_unit_code', '=', 'package_types.package_code')
                ->where('product_packaging_details.product_code', '=', $product_code)
                ->select(['package_types.package_name as name', 'product_packaging_details.super_unit_code as super', 'product_packaging_details.macro_to_super_value as value'])
                ->first();
            $configuration->code = 'Super';
            $configurations[] = $configuration;
        }

        return response()->json(['msg' => 'success', 'data' => $configurations ]);
    }
}
