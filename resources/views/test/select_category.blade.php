<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 24px; font-weight: bold; color: #333; padding: 10px 0;">
            Start Test
        </h2>
    </x-slot>

    <div style="max-width: 800px; margin: 0 auto; padding: 20px;">
        <h3 style="font-size: 18px; margin-bottom: 20px;">Select Category to Start Test</h3>

        <form action="{{ route('test.start') }}" method="POST">
            @csrf
            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                <button name="category_id" value="all" style="padding: 15px 25px; background-color: #e0e0e0; border: 1px solid #ccc; cursor: pointer;">
                    ALL QUESTIONS
                </button>
                @foreach($categories as $category)
                    <button name="category_id" value="{{ $category->id }}" style="padding: 15px 25px; background-color: #cce0ff; border: 1px solid #99c2ff; cursor: pointer;">
                        {{ strtoupper($category->name) }}
                    </button>
                @endforeach
            </div>
        </form>
    </div>
</x-app-layout>
