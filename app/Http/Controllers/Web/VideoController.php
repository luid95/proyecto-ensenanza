<?php

namespace App\Http\Controllers\Web;

use App\Models\Video;
use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index($videoId)
    {
        // Obtener el video a partir del ID
        $video = Video::findOrFail($videoId);

        // Retornar la vista para ver el video
        return view('videos.view', compact('video'));
    }

    public function create($course_id)
    {
        $course = Course::findOrFail($course_id);

        if($course){
            $course_id = $course->id;
        }
        return view('videos.create', compact('course_id'));
    }

    public function store(Request $request)
    {
        // Validación del título (debe ser único para el curso)
        $request->validate([
            'title' => 'required|unique:videos,title,NULL,NULL,course_id,' . $request->course_id,
            'url' => 'required|url',
        ]);

        // Obtener el curso asociado
        $course = Course::findOrFail($request->course_id);

        // Crear el video (sin necesidad de especificar la categoría, ya que se asocia con el curso)
        $video = new Video();
        $video->title = $request->title;
        $video->url = $request->url;
        $video->course_id = $course->id; // Solo se guarda el curso
        $video->minutes = 10;

        $video->save();

        return redirect()->route('courses.show', $course->id)->with('success', 'Video creado con éxito');
    }
}
