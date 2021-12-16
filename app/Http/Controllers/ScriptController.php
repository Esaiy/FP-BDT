<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ScriptController extends Controller
{
    public function index()
    {
        $jsonFile = file_get_contents(__DIR__.'\News_Category_Dataset_v2.json');

        $jsonObject = json_decode($jsonFile, true);

        // create user
        $i = 0;
        $author = array();
        foreach ($jsonObject as $key => $value) {
            if ($value['authors'] == "") {
                continue;
            }
            // check if user exist
            if (isset($author[$value['authors']])) {
                continue;
            }
            
            $user = new User();
            $user->name = $value['authors'];
            $user->email = "author_" . $i . "@gmail.com";
            $user->password = Hash::make("123123123");
            $user->save();

            $author[$value['authors']] = $user->id;
            $i++;
        }

        // create category
        $i = 0;
        $categories = array();
        foreach ($jsonObject as $key => $value) {
            if ($value['authors'] == "") {
                continue;
            }

            // check if category exist
            if (isset($categories[$value['category']])) {
                continue;
            }
            
            $category = new Category();
            $category->name = $value['category'];
            $category->slug = Str::slug($value['category']);
            $category->save();

            $categories[$value['category']] = $category->id;
            $i++;
        }

        // create article
        $i = 0;
        $articles = array();
        foreach ($jsonObject as $key => $value) {
            if ($value['authors'] == "") {
                continue;
            }
            
            // check if article exist
            if (isset($articles[$value['headline']])) {
                continue;
            }
            
            $article = new Article();
            $article->headline = $value['headline'];
            $article->author_id = $author[$value['authors']];
            $article->category_id = $categories[$value['category']];
            $article->slug = Str::slug($value['headline']);
            $article->link = $value['link'];
            $article->description = $value['short_description'];
            $article->date = $value['date'];
            $article->is_active = true;
            $article->save();

            $articles[$value['headline']] = $article->id;
            $i++;
        }

        return "finished";
    }
}
