<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;



class BlogController extends Controller
{
  //

  public function index(Request $request)
  {
    // $categories = Category::select('id','categoryName')->get();
    $categories = Category::all();


    $blogs = Blog::orderby('id', 'desc')->with(['cat', 'user'])->limit(6)->get(['id', 'title', 'post_excerpt', 'slug', 'user_id', 'featuredimage',]);
    return view('home')->with(['categories' => $categories, 'blogs' => $blogs]);
  }

  public function blogSingle(Request $request, $slug)
  {
    //$categories = Category::all();
    $blogs = Blog::Where('slug', $slug)->with(['cat', 'tag', 'user'])->first(['id', 'title', 'user_id', 'featuredimage', 'post']);
    $category_ids = [];
    foreach ($blogs->cat as $cat) {
      array_push($category_ids, $cat->id);
    }
    $relatedBlogs = Blog::with('user')->where('id', '!=', $blogs->id)->whereHas('cat', function ($q)  use ($category_ids) {
      $q->whereIn('category_id', $category_ids);
    })->limit(5)->orderBy('id', 'desc')->get(['id', 'title', 'slug', 'user_id', 'featuredimage']);
    return view('blogSingle')->with(['blogs' => $blogs, 'relatedBlogs' => $relatedBlogs]);
  }

  public function compose(View $view)
  {

    $cat = Category::select('id', 'categoryName')->get('id', 'categorName');
    $user = Auth::user();

    $view->with('cat', $cat );
    $view->with('user', $user );

  }

  public function categoryIndex(Request $request, $categoryName, $id)
  {
    $blogs = Blog::with('user')->whereHas('cat', function ($q)  use ($id) {
      $q->where('category_id', $id);
    })->orderBy('id', 'desc')->select('id', 'title', 'slug', 'user_id', 'featuredimage')->paginate(1);
    return view('category')->with(['categoryName' => $categoryName, 'blogs' => $blogs]);
  }

  public function tagIndex(Request $request, $tagName, $id)
  {
    $blogs = Blog::with('user')->whereHas('tag', function ($q)  use ($id) {
      $q->where('tag_id', $id);
    })->orderBy('id', 'desc')->select('id', 'title', 'slug', 'user_id', 'featuredimage')->paginate(1);
    return view('tags')->with(['tagName' => $tagName, 'blogs' => $blogs]);
  }

  public function allBlogs(Request $request)
  {
    $blogs = Blog::orderby('id', 'desc')->with(['cat', 'user'])->select('id', 'title', 'post_excerpt', 'slug', 'user_id', 'featuredimage',)->paginate(1);
    return view('blogs')->with(['blogs' => $blogs]);
  }

  public function search(Request $request)
  {
    $str = $request->str;
    $blogs = Blog::orderby('id', 'desc')->with(['cat', 'user'])->select('id', 'title', 'post_excerpt', 'slug', 'user_id', 'featuredimage',);

    $blogs->when($str!='',function($q) use($str){
      $q->where('title', 'LIKE', "%{$str}%")
      ->orwhereHas('cat', function ($q) use ($str) {
        $q->where('categoryName', $str);
      })
      ->orwhereHas('tag', function ($q) use ($str) {
        $q->where('tagName', $str);
      });
    });
    $blogs= $blogs->paginate(1);
   $blogs= $blogs->appends($request->all());
   return view('blogs')->with(['blogs' => $blogs]);


    // if (!$str) {
    // }

    // $blogs->where('title', 'LIKE', "%{$str}%")
    //   ->orwhereHas('cat', function ($q) use ($str) {
    //     $q->where('categoryName', $str);
    //   })
    //   ->orwhereHas('tag', function ($q) use ($str) {
    //     $q->where('tagName', $str);
    //   });
    // return $blogs->get();
  }

  //Add comment
  public function addcomment(Request $request)
  {
      // //validate request
      // $this->validate($request, [

      //     'commenttxt' => 'required',
      // ]);

      return Comment::create([
          'commenttxt' => $request->commentTxt,
          'user_id' => Auth::user()->id,
       ]);
       
  }

  //get
  public function get_comments()
  {
      return Comment::with('user')->OrderBy('id', 'desc')->get();
  }

  //comment index

 public function commentIndex(Request $request, $commentTxt, $id)
  {
    $comments = Comment::with('user')->whereHas('user', function ($q)  use ($id) {
      $q->where('user_id', $id);
    })->orderBy('id', 'desc')->select('id', 'commentTxt', 'user_id')->paginate(1);
    return view('blogSingle')->with(['commentTxt' => $commentTxt, 'comments' => $comments]);
  }

   // User Login 

   public function userlogin(Request $request)
   {
   
    $user = Auth::user();


      //  //validate request
      //  $this->validate($request, [
      //      'email' => "bail|required|email",
      //      'password' => 'bail|required|min:6',
      //  ]);

       if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
           return response()->json([
            'msg' => 'You are logged in',
            'user' => $user,

         ]);


  
           
          //  if ($user->role->isAdmin == 0) {
          //      Auth::logout();
          //      return response()->json([
          //          'msg' => 'Incorrect Login Details',
          //      ], 401);
          //  }
           
       } else {
           return response()->json([
               'msg' => 'Incorrect login details',
           ], 401);
       }
   }
  
   public function loginpage(Request $request)
   {
     
       return view('login');
   }
   //logout
   public function logout()
   {
       Auth::logout();
       return redirect('/loginpage');
   }
   


}
