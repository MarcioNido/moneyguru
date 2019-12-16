<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::orderBy('level1')
            ->orderBy('level2')
            ->orderBy('level3')
            ->paginate(10);
    }


    /**
     * Special dropdown with groups
     *
     * @return JsonResponse dropdown list
     */
    public function dropDown()
    {

        $result = [];
        $level1 = Category::where('level2', 0)->orderBy('level1')->get();
        foreach($level1 as $l1) {

            $result[$l1->level1 . ' - '.$l1->name] = [];
            $level2 = Category::where('level1', $l1->level1)->where('level3', 0)->orderBy('level2')->get();

            foreach($level2 as $l2) {

                $level3 = Category::where('level1', $l2->level1)
                    ->where('level2', $l2->level2)
                    ->where('level3', '<>', 0)->orderBy('level3')->get();

                foreach ($level3 as $l3) {

                    $result[$l2->level1 . '.' . $l2->level2 . ' - ' . $l2->name][$l3->id] = $l3->name;

                }


            }


        }

        return JsonResponse::create(['data' => $result]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Category::$validationRules);

        return Category::create($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate(Category::$validationRules);

        $category->fill($request->all());

        $category->save();

        return $category;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category) {
            $category->delete();
        }

        return JsonResponse::create(['status' => 'success']);
    }
}
