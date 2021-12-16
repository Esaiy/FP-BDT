<?php

require './vendor/autoload.php';

use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

$jsonFile = file_get_contents('./script/News_Category_Dataset_v2.json');

$jsonObject = json_decode($jsonFile, true);

// create user
$i = 0;
$author = array();
foreach ($jsonObject as $key => $value) {
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

echo "finished author";

// create category
$i = 0;
$category = array();
foreach ($jsonObject as $key => $value) {
    // check if category exist
    if (isset($category[$value['category']])) {
        continue;
    }
    
    $category = new Category();
    $category->name = $value['category'];
    $category->slug = Str::slug($value['category']);
    $category->save();

    $category[$value['category']] = $category->id;
    $i++;
}

echo "finished category";

// create article
$i = 0;
$article = array();
foreach ($jsonObject as $key => $value) {
    // check if article exist
    if (isset($article[$value['title']])) {
        continue;
    }
    
    $article = new Article();
    $article->headline = $value['title'];
    $article->author_id = $author[$value['authors']];
    $article->category_id = $category[$value['category']];
    $article->slug = Str::slug($value['title']);
    $article->link = $value['link'];
    $article->description = $value['short_description'];
    $article->date = $value['date'];
    $article->save();

    $article[$value['title']] = $article->id;
    $i++;
}

echo "finished";

?>
