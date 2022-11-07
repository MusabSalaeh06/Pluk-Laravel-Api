<?php

namespace App\Http\Controllers;

use App\testvdoc;
use Illuminate\Http\Request;

class TestvdocController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $con = testvdoc::get(); 
        return view('testvdoc.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'description'=>'required',
            'link_y'=>'',
            'link_g'=>'', 
            'up_image'=>'mimes:jpg,jpeg,png',
            'up_video'=>'mimes:mp4',
            'document'=>'mimes:pdf,docx,pptx',
        ]);

       $post = new testvdoc;
       $post->title = $request->input('title');
       $post->description = $request->input('description');
       $post->link_y = $request->input('link_y');
       $post->link_g = $request->input('link_g');

       if   ($request->file('up_image')) {
        $file=$request->file('up_image');
        $filename = time().'_'.$file->getClientOriginalExtension();
        $request->up_image->move('storage/testvdoc/image_assets',$filename);
        $post->up_image =$filename; 
            } 
            /** */
       if   ($request->file('up_video')) {
        $file=$request->file('up_video');
        $fileN=$request->input('title');
        $filename = $fileN.'.'.$file->getClientOriginalExtension();
        $request->up_video->move('storage/testvdoc/video_assets',$filename);
        $post->up_video =$filename; 
        } 
        /***/
        if   ($request->file('document')) {
        $file=$request->file('document');
        $fileN=$request->input('title');
        $filename = $fileN.'.'.$file->getClientOriginalExtension();
        $request->document->move('storage/testvdoc/document_assets',$filename);
        $post->document =$filename; 
        } 
       //dd($post);
       $post->save();
       return redirect('/testvdoc_show');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\testvdoc  $testvdoc
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $testvdoc=testvdoc::paginate(10);
        return view('testvdoc.show',compact(['testvdoc']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\testvdoc  $testvdoc
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data=testvdoc::find($id); 
        return view('testvdoc.edit',compact(['data']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\testvdoc  $testvdoc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'=>'required',
            'description'=>'required',
            'link_y'=>'required',
            'link_g'=>'required',
            'up_image'=>'required|mimes:jpg,jpeg,png',
            'up_video'=>'mimes:mp4',
            'document'=>'required|mimes:pdf,doc',
        ]);

       $post = testvdoc::find($id);
       $post->title = $request->input('title');
       $post->description = $request->input('description');
       $post->link_y = $request->input('link_y');
       $post->link_g = $request->input('link_g');

       if   ($request->file('up_image')) {
        $file=$request->file('up_image');
        $filename = time().'_'.$file->getClientOriginalExtension();
        $request->up_image->move('storage/testvdoc/image_assets',$filename);
        $post->up_image =$filename; 
            } 

       if   ($request->file('up_video')) {
        $file=$request->file('up_video');
        $filename = time().'_'.$file->getClientOriginalExtension();
        $request->up_video->move('storage/testvdoc/video_assets',$filename);
        $post->up_video =$filename; 
        } 

        if   ($request->file('document')) {
        $file=$request->file('document');
        $filename = time().'_'.$file->getClientOriginalExtension();
        $request->document->move('storage/testvdoc/document_assets',$filename);
        $post->document =$filename; 
        } 
       //dd($post);
       $post->save();
       return redirect('/testvdoc_show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\testvdoc  $testvdoc
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        testvdoc::find($id)->delete();
        return redirect('/testvdoc_show');
    }
    
}
