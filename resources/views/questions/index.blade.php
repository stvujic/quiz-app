@php use Illuminate\Support\Facades\Auth; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 24px; font-weight: bold; color: #333; padding: 10px 0;">
            @if ($status === 'all')
                All Questions
            @elseif ($status === 'know')
                Questions I Know
            @elseif ($status === 'dont_know')
                Questions I Don’t Know
            @endif
        </h2>
    </x-slot>

    <div style="padding: 20px;">
        <div style="max-width: 1000px; margin: 0 auto;">
            @if ($questions->isEmpty())
                <p style="color: #888;">No questions found for this category.</p>
            @else
                <div style="background-color: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05); overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead style="background-color: #f2f2f2;">
                        <tr>
                            <th style="text-align: left; padding: 12px;">Question</th>
                            <th style="text-align: left; padding: 12px;">Category</th>
                            <th style="text-align: left; padding: 12px;">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($questions as $question)
                            @php
                                $userStatus = $question->userQuestionStatuses
                                    ->where('user_id', Auth::id())
                                    ->first()?->status;
                                $statusText = $userStatus === 'know' ? 'I Know' : ($userStatus === 'dont_know' ? 'I Don’t Know' : 'Set Status');
                                $statusColor = $userStatus === 'know' ? '#28a745' : ($userStatus === 'dont_know' ? '#dc3545' : '#6c757d');
                            @endphp
                            <tr style="border-top: 1px solid #ddd;">
                                <td style="padding: 12px;">{{ $question->text }}</td>
                                <td style="padding: 12px;">{{ $question->category->name ?? 'Uncategorized' }}</td>
                                <td style="padding: 12px;">
                                    <a href="{{ route('questions.edit', $question->id) }}" style="margin-right: 15px; color: #007bff; text-decoration: none;">Edit</a>

                                    <form action="{{ route('questions.destroy', $question->id) }}" method="POST" style="display:inline; margin-right: 15px;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this question?')" style="color: #000; background: none; border: none; cursor: pointer;">
                                            Delete
                                        </button>
                                    </form>

                                    <form action="{{ route('questions.toggleStatus', $question->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" style="color: {{ $statusColor }}; background: none; border: none; cursor: pointer;">
                                            {{ $statusText }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
