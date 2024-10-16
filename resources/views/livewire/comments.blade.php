<div>

    <section class="bg-white dark:bg-gray-900 py-8 lg:py-16">
        <div class="max-w-2xl mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">Discussion
                    ({{$comments->count()}})</h2>
            </div>
            @auth
                @include('commentify::livewire.partials.comment-form',[
                    'method'=>'postComment',
                    'state'=>'newCommentState',
                    'inputId'=> 'comment',
                    'inputLabel'=> 'Your comment',
                    'button'=>'Post comment'
                ])
            @else
                <a class="mt-2 text-sm" href="/login">Log in to comment!</a>
            @endauth
            @if($comments->count())
                <button wire:click="toggleComments">
                    {{ $showComments ? 'Hide Comments' : 'Show Comments('.$comments->count().')' }}
                </button>

                @if($showComments)
                <select wire:model.live="sortBy" class="select5">
                    <option class="option5" value="newest">Newest</option>
                    <option class="option5" value="most_liked">Most Liked</option>
                </select>

                    @foreach($this->sortedComments   as $comment)
                        <livewire:comment :$comment :key="$comment->id"/>
                    @endforeach
                    {{$comments->links()}}
                @endif
            @else
                <p>No comments yet!</p>
            @endif
        </div>
    </section>
</div>
