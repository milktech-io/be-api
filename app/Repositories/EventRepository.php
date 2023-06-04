<?php

namespace App\Repositories;

use App\Models\Event;
use App\Models\EventComment;
use App\Models\EventLike;
use App\Traits\PaginateRepository;
use Auth;

class EventRepository
{
    use PaginateRepository;

    public function all()
    {
        return ok('', Event::select('image_url', 'title', 'body', 'created_at', 'id')->get());
    }

    public function store($data)
    {
        $data['created_by'] = Auth::user()->id;
        $event = Event::create($data);
        $event->storeImage($data['image'], 'image_url');

        return ok('Evento guardado correctamente', $event);
    }

    public function destroy($event)
    {
        $event->unlink('image_url');
        $event->delete();

        return ok('Evento eliminado');
    }

    public function like($event)
    {
        $like = $event->like;

        if ($like) {
            $like->delete();
        } else {
            $like = EventLike::create([
                'event_id' => $event->id,
                'user_id' => Auth::user()->id,
            ]);
        }

        return ok('movimiento registrado correctamente', Event::find($event->id));
    }

    public function comment($data, $event)
    {
        $data['user_id'] = Auth::user()->id;
        $data['event_id'] = $event->id;

        EventComment::create($data);

        $event->comments;

        return ok('Comentario creado correctamente', $event);
    }
}
