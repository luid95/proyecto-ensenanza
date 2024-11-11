<?php

namespace App\Http\Controllers\Web;

use App\Models\Video;
use App\Models\Course;
use App\Models\CourseUser;
use App\Models\Comment;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    public function index($videoId)
    {
        // Obtener el video a partir del ID
        $video = Video::findOrFail($videoId);
        $course = $video->course;

        // Obtener el progreso del usuario en el curso
        $courseUser = CourseUser::where('user_id', Auth::id())
        ->where('course_id', $course->id)
        ->first();
        
        // Si no hay progreso para el curso y el usuario, se establece en 0
        if (!$courseUser) {
            $progress = 0;
        } else {
            // Obtener todos los videos del curso y los registros de progreso para este curso y usuario
            $progress = CourseUser::where('user_id', Auth::id())
                                ->where('course_id', $course->id)
                                ->sum('progress'); // Sumar todos los minutos de los videos vistos por el usuario
        }

        // Obtener los videos vistos por el usuario en este curso
        $watchedVideos = CourseUser::where('user_id', Auth::id())
        ->where('course_id', $course->id)
        ->pluck('current_video_id')
        ->toArray();

        // Calcular el progreso total del curso
        $totalMinutes = $course->videos->sum('minutes');

        // Calcular el porcentaje de progreso
        $progressPercentage = $totalMinutes > 0 ? ($progress / $totalMinutes) * 100 : 0;

        // Retornar la vista para ver el video
        return view('videos.view', compact('video', 'course', 'progressPercentage', 'progress',  'watchedVideos'));
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

    public function markAsWatched($videoId, $courseId)
    {
        $user = auth()->user(); // Obtener el usuario autenticado
        
        // Verificar si el video y el curso existen
        $video = Video::findOrFail($videoId);
        $course = $video->course;

        // Verificar si el usuario está inscrito en el curso
        $courseUser = CourseUser::where('course_id', $courseId)
                                ->where('user_id', $user->id)
                                ->where('current_video_id', $video->id)
                                ->first();
        if (!$courseUser) {
            // Si no existe, crea un nuevo progreso
            $new_reg = CourseUser::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'current_video_id' => $video->id,
                'progress' => $video->minutes
            ]);
            $new_reg->save();

            return response()->json(['message' => 'Progreso actualizado.']);
        }

    }

    public function storeComment(Request $request, $videoId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'video_id' => $videoId,
            'content' => $request->content,
            'approved' => 1, // Por defecto aprobado
        ]);

        return back()->with('message', 'Comentario enviado y esperando aprobación');
    }

    public function toggleLike(Request $request, $videoId)
    {
        $video = Video::findOrFail($videoId);
        $user = $request->user();

        if ($user->likedVideos()->where('video_id', $video->id)->exists()) {
            $user->likedVideos()->detach($video->id);
            return response()->json(['message' => 'Like removido.']);
        } else {
            $user->likedVideos()->attach($video->id);
            return response()->json(['message' => 'Like agregado.']);
        }
    }

}
