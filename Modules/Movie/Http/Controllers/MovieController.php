<?php

namespace Modules\Movie\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Movie\Entities\Category;
use Modules\Movie\Entities\CategoryMovie;
use Modules\Movie\Entities\Movie;

class MovieController extends Controller
{

    protected $domain ='https://api.themoviedb.org/3';
    private $api_key ='01101a62163e8e274816718e6e6eaf45';

    function curl_call($url,$page){
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $this->domain.$url.'?api_key='.$this->api_key.'&page='.$page);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    /**
     * * add categories from api
     */

    function add_categories()
    {
        $url ='/genre/movie/list';
        $data = $this->curl_call($url,1);

        $data_added_count = 0;
        foreach (json_decode($data)->genres as $category_data)
        {
            if (Category::find($category_data->id) == null)
            {
                $category = new Category();
                $category->id = $category_data->id;
                $category->name = $category_data->name;
                $category->save();
                $data_added_count++;
            }
        }

        return $data_added_count. " categories added successfully";

    }


    function store_movie($movie_data){
        $movie = new Movie();
        $movie->id = $movie_data->id;
        $movie->adult = $movie_data->adult;
        $movie->backdrop_path = $movie_data->backdrop_path;
        $movie->original_language = $movie_data->original_language;
        $movie->original_title = $movie_data->original_title;
        $movie->overview = $movie_data->overview;
        $movie->poster_path = $movie_data->poster_path;
        $movie->release_date = $movie_data->release_date;
        $movie->title = $movie_data->title;
        $movie->popularity = $movie_data->popularity;
        $movie->vote_average = $movie_data->vote_average;
        $movie->vote_count = $movie_data->vote_count;
        $movie->video = $movie_data->video;
        $movie->save();
        return $movie;
    }


    function store_movie_category($movie,$genre_id){
        $category_movie = new CategoryMovie();
        $category_movie->movie_id = $movie->id;
        $category_movie->category_id = $genre_id;
        $category_movie->save();
    }
    /**
     * * add  top rated movies from api
     */

    function add_top_rated_movies()
    {
        $data_added_count = 0;
        $page = 1;

        start:
        $url ='/movie/top_rated';
        $data = $this->curl_call($url,$page);

        foreach (json_decode($data)->results as $movie_data)
        {
            if (Movie::find($movie_data->id) == null)
            {
               $movie = $this->store_movie($movie_data);

                foreach($movie_data->genre_ids as $genre_id ){
                  $this->store_movie_category($movie,$genre_id);
                }
                $data_added_count++;
            }
        }
        if ($data_added_count <json_decode($data)->total_results) {
            $page++;
            goto start;
        }
        return $data_added_count. " movies added successfully";

    }


    /**
     * * add  top rated movies from api
     */

    function add_latest_movie()
    {

        $url ='/movie/latest';
        $data = $this->curl_call($url,1);

        $movie_data =json_decode($data);
        $movie = $this->store_movie($movie_data);

                foreach($movie_data->genres as $genre_id ){
                    $this->store_movie_category($movie,$genre_id);
                }

        return "latest movie added successfully";

    }

    /**
     *
     *
     * Display a listing of the resource.
     * @return Renderable
     */

    public function index()
    {
        return view('movie::index');
    }

    public function api_movies(Request $request)
    {

        $movies = Movie::where('title','<>',null);

        if($request->has('category_id')){
            $movies_ids = CategoryMovie::where('category_id',$request->category_id)->pluck('movie_id')->toArray();
            $movies = $movies->whereIn('id',$movies_ids);
        }

        if($request->has('popular|desc')){

            $movies = $movies->orderBy('popularity','desc');
        }
        elseif($request->has('popular|asc')){

            $movies = $movies->orderBy('popularity','asc');
        }


        if($request->has('rated|desc')){

            $movies = $movies->orderBy('vote_count','desc');
        }
        elseif($request->has('rated|asc')){

            $movies = $movies->orderBy('vote_count','asc');
        }

        $movies = $movies->paginate(10);

        return response()->json(['results' => $movies], 200);
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('movie::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('movie::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('movie::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
