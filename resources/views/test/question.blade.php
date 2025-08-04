<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 24px; font-weight: bold; color: #333; padding: 10px 0;">
            Test Mode
        </h2>
    </x-slot>

    <div style="max-width: 800px; margin: 0 auto; padding: 20px;">
        <div style="background-color: #f9f9f9; border: 1px solid #ddd; padding: 15px; margin-bottom: 20px;">
            <p style="font-weight: bold; margin-bottom: 10px;">Question:</p>
            <p>{{ $question->text }}</p>
        </div>

        <form action="{{ route('test.answer') }}" method="POST" style="margin-bottom: 30px;">
            @csrf
            <input type="hidden" name="question_id" value="{{ $question->id }}">
            <input type="hidden" name="category_id" value="{{ $categoryId }}">

            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <button type="submit" name="action" value="dont_know" style="padding: 10px 20px; background-color: #cc0000; color: white; border: none; cursor: pointer;">
                    I don't know
                </button>
                <button type="submit" name="action" value="know" style="padding: 10px 20px; background-color: #009900; color: white; border: none; cursor: pointer;">
                    I know
                </button>
                <button type="submit" name="action" value="next" style="padding: 10px 20px; background-color: #777; color: white; border: none; cursor: pointer;">
                    Next
                </button>
            </div>
        </form>

        @if(request('action') === 'dont_know')
            <div style="background-color: #ffffcc; border: 1px solid #ddd; padding: 15px;">
                <p style="font-weight: bold;">Answer:</p>
                <p>{{ $question->answer }}</p>
            </div>
        @endif
    </div>
</x-app-layout>
