<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $blogs = Blog::latest()->get();
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        
        $request->validate([
            'title' => 'required',
            'meta_description' => 'required',
        ]);

        $data = $request->all();
        $data['slug'] = $request->slug ?: Str::slug($request->title);
        
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/blogs'), $filename);
            $data['featured_image'] = '/uploads/blogs/' . $filename;
        }

        Blog::create($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully!');
    }

    public function edit($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $blog = Blog::findOrFail($id);
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        
        $request->validate([
            'title' => 'required',
            'meta_description' => 'required',
        ]);

        $blog = Blog::findOrFail($id);
        $data = $request->all();
        $data['slug'] = $request->slug ?: Str::slug($request->title);

        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/blogs'), $filename);
            $data['featured_image'] = '/uploads/blogs/' . $filename;
        }

        $blog->update($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully!');
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $blog = Blog::findOrFail($id);
        $blog->delete();
        return back()->with('success', 'Blog deleted successfully!');
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        $related = Blog::where('status', 1)->where('id', '!=', $blog->id)->limit(3)->get();
        return view('blog.show', compact('blog', 'related'));
    }

    public function publicIndex(Request $request)
    {
        $resource = $request->get('resource', 'blog');
        
        if ($resource === 'guide') {
            $query = \App\Models\Guide::where('status', 1);
        } else {
            $query = Blog::where('status', 1);
        }

        if ($request->has('category') && !empty($request->category)) {
            $query->where('tags', 'LIKE', '%' . $request->category . '%');
        }

        $blogs = $query->latest()->paginate(10);
        
        // Get popular items (from current resource)
        if ($resource === 'guide') {
            $popular = \App\Models\Guide::where('status', 1)->latest()->limit(5)->get();
        } else {
            $popular = Blog::where('status', 1)->latest()->limit(5)->get();
        }
        
        // Get unique tags for the category filter
        $categories = ['Facebook', 'Instagram', 'TikTok', 'YouTube', 'Twitter']; 

        return view('blogs', compact('blogs', 'popular', 'categories', 'resource'));
    }
}
