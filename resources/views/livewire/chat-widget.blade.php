<?php

use Livewire\Volt\Component;
use OpenAI\Laravel\Facades\OpenAI;
use Livewire\Attributes\On;

new class extends Component {
    public bool $isOpen = false;
    public bool $isExpanded = false;
    public array $messages = [];
    public string $input = '';
    public string $currentResponse = '';

    public function mount()
    {
        // Initialize with empty messages or load from session if we want persistence across pages
        // For now, ephemeral like the React widget
    }

    public function toggleChat()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function toggleExpand()
    {
        $this->isExpanded = !$this->isExpanded;
    }

    public function sendMessage()
    {
        $input = trim($this->input);
        if (empty($input)) {
            return;
        }

        // Add user message
        $this->messages[] = [
            'role' => 'user',
            'content' => $input,
        ];

        $this->input = '';
        $this->currentResponse = ''; // Reset current response buffer

        // Stream response
        $this->streamResponse();
    }

    public function streamResponse()
    {
        // Format messages for OpenAI
        $apiMessages = collect($this->messages)->map(function ($msg) {
            return [
                'role' => $msg['role'],
                'content' => $msg['content'],
            ];
        })->toArray();

        $assistantId = config('openai.assistant_id');

        try {
            if ($assistantId) {
                $stream = OpenAI::threads()->createAndRunStreamed([
                    'assistant_id' => $assistantId,
                    'temperature' => 0,
                    'thread' => [
                        'messages' => $apiMessages,
                    ],
                ]);

                foreach ($stream as $response) {
                    if ($response->event === 'thread.message.delta') {
                        $chunk = $response->response->delta->content[0]->text->value ?? '';
                        if (!empty($chunk)) {
                            $this->currentResponse .= $chunk;
                            $this->stream('response-stream', $chunk, true);
                        }
                    }
                }
            } else {
                 $stream = OpenAI::chat()->createStreamed([
                     'model' => 'gpt-4o',
                     'messages' => $apiMessages,
                 ]);

                foreach ($stream as $response) {
                    $chunk = $response->choices[0]->delta->content ?? '';
                    if (!empty($chunk)) {
                        $this->currentResponse .= $chunk;
                        $this->stream('response-stream', $chunk, true);
                    }
                }
            }
        } catch (\Exception $e) {
            $this->messages[] = [
                'role' => 'assistant',
                'content' => 'Error: ' . $e->getMessage(),
            ];
            return;
        }
        
        // Add full response to messages array
        $this->messages[] = [
            'role' => 'assistant',
            'content' => $this->currentResponse,
        ];
        
        $this->currentResponse = ''; // Clear buffer after saving
    }
}; ?>

<div class="fixed bottom-6 right-6 z-50 font-sans">
    @if(!$isOpen)
        <button 
            wire:click="toggleChat"
            class="h-14 w-14 rounded-full shadow-lg bg-black text-white flex items-center justify-center hover:bg-gray-800 transition-all duration-300"
        >
            <x-heroicon-o-chat-bubble-left-right class="h-8 w-8" />
        </button>
    @else
        <div 
            class="bg-white rounded-lg shadow-xl flex flex-col transition-all duration-300 border border-gray-200 dark:bg-gray-900 dark:border-gray-700"
            style="width: {{ $isExpanded ? '800px' : '400px' }}; height: {{ $isExpanded ? '80vh' : '600px' }};"
        >
            <!-- Header -->
            <div class="flex flex-row items-center justify-between py-3 px-4 border-b border-gray-200 dark:border-gray-700">
                <div class="text-lg font-semibold flex items-center gap-2 text-gray-900 dark:text-gray-100">
                    <x-heroicon-o-chat-bubble-left-right class="h-5 w-5" />
                    AI Assistant
                </div>
                <div class="flex items-center gap-1">
                    <button wire:click="toggleExpand" class="p-1 hover:bg-gray-100 dark:hover:bg-gray-800 rounded text-gray-500">
                        @if($isExpanded)
                            <x-heroicon-o-arrows-pointing-in class="h-5 w-5" />
                        @else
                            <x-heroicon-o-arrows-pointing-out class="h-5 w-5" />
                        @endif
                    </button>
                    <button wire:click="toggleChat" class="p-1 hover:bg-gray-100 dark:hover:bg-gray-800 rounded text-gray-500">
                        <x-heroicon-o-x-mark class="h-5 w-5" />
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-hidden p-0 flex flex-col relative">
                <div class="flex-1 overflow-y-auto p-4 space-y-4" id="chat-container">
                    @if(empty($messages) && empty($currentResponse))
                        <div class="flex flex-col items-center justify-center h-full text-center text-gray-400 p-4">
                            <x-heroicon-o-chat-bubble-left-right class="h-12 w-12 mb-4 opacity-20" />
                            <p>How can I help you today?</p>
                        </div>
                    @endif

                    @foreach($messages as $msg)
                        <div class="flex {{ $msg['role'] === 'user' ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[80%] rounded-lg p-3 {{ $msg['role'] === 'user' ? 'bg-black text-white' : 'bg-gray-100 text-gray-900 dark:bg-gray-800 dark:text-gray-100' }}">
                                <p class="whitespace-pre-wrap text-sm">{{ $msg['content'] }}</p>
                            </div>
                        </div>
                    @endforeach

                    <!-- Streaming Response -->
                    @if(!empty($currentResponse) || $currentResponse === '') 
                        <!-- Always render this div so wire:stream can target it? No, wire:stream targets based on name. -->
                    @endif
                    
                    <div wire:stream="response-stream" class="flex justify-start hidden" x-data="{ show: false }" x-show="show" x-init="$watch('$el.innerHTML', () => { show = $el.innerHTML.length > 0 })" :class="{ 'hidden': !show, 'flex': show }">
                        <div class="max-w-[80%] rounded-lg p-3 bg-gray-100 text-gray-900 dark:bg-gray-800 dark:text-gray-100">
                            <p class="whitespace-pre-wrap text-sm"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-3 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
                <form wire:submit="sendMessage" class="flex w-full gap-2">
                    <input
                        wire:model="input"
                        type="text"
                        placeholder="Type a message..."
                        class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black dark:bg-gray-800 dark:border-gray-700 dark:text-white sm:text-sm"
                        {{ !empty($currentResponse) ? 'disabled' : '' }}
                        autofocus
                    />
                    <button 
                        type="submit" 
                        class="p-2 bg-black text-white rounded-md hover:bg-gray-800 disabled:opacity-50 disabled:cursor-not-allowed"
                        {{ !empty($currentResponse) ? 'disabled' : '' }}
                    >
                        <x-heroicon-o-paper-airplane class="h-4 w-4" />
                    </button>
                </form>
            </div>
        </div>
    @endif
    
    <script>
        // Auto-scroll to bottom
        document.addEventListener('livewire:initialized', () => {
            const container = document.getElementById('chat-container');
            
            Livewire.hook('morph.updated', ({ el, component }) => {
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            });

            // Also scroll when streaming
            // We can observe changes to the container
            const observer = new MutationObserver(() => {
                if (container) {
                     container.scrollTop = container.scrollHeight;
                }
            });
            
            if (container) {
                observer.observe(container, { childList: true, subtree: true, characterData: true });
            }
        });
    </script>
</div>