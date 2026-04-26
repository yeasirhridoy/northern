<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\On;

new class extends Component {
    public bool $isOpen = false;
    public bool $isExpanded = false;
    public array $messages = [];
    public string $input = '';
    public string $currentResponse = '';

    public function mount()
    {
        // Ephemeral chat session
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
        
        // Dispatch event to trigger AI response in a separate request
        $this->dispatch('generate-response');
    }

    #[On('generate-response')]
    public function getResponse()
    {
        $systemPrompt = <<<EOT
You are a professional and helpful Admission Agent for Northern University. Your goal is to assist prospective students with their inquiries using ONLY the information provided below.

RULES:
1. Be professional, polite, and welcoming.
2. Only answer questions related to Northern University admissions, requirements, fees, and related academic info.
3. If a question is unrelated to the university, politely inform the user that you are an admission assistant and can only help with NUB-related queries.
4. Do NOT hallucinate. If info is missing, ask the user to contact the admission office.
5. Provide clear, structured answers.

ADMISSION INFORMATION:
- Admission fee: Tk. 16,700 for Undergraduates & Tk. 11,200 for Postgraduates (Non-refundable).

Undergraduate Requirements:
- Minimum GPA 2.50 in both SSC & HSC.
- O Level: 5 subjects; A Level: 2 subjects (min 'B' in 4, 'C' in 3).
- GED: Min 410 marks in each subject, 450 average.
- Engineering: Min GPA 2.5 in SSC & HSC (Science group + Math in HSC).
- B. Pharm: Min GPA 3.00 in SSC & HSC (Biology, Physics & Chemistry required).

Postgraduate Requirements:
- Min CGPA 2.00 in bachelor degree and min 4 points combined in SSC/HSC.
- Executive MBA: Min 2 years job experience post-graduation.
- MPH: MBBS or equivalent, B.Sc in Nursing, or BSS (4 years).

Required Documents:
- All academic Transcripts, Certificates, and Testimonials (Original + Photocopy).
- Job experience certificate (for Executive MBA).
- 3 passport size & 3 stamp size color photos (formal dress).
- Printed copy of applicant's NUB online admission profile.

Payment & Installments:
- Total charge = (Per Cr. Cost x Total Cr) + Semester Fee.
- 40% payable during registration.
- 30% before Mid-term Exam.
- 30% before Final Exam.

Financial Assistance (Waiver for Undergraduate Only):
- GPA 5.00 in both SSC & HSC: 50% waiver.
- GPA 4.80-4.99 in both: 30% waiver.
- GPA 4.50-4.79 in both: 20% waiver.
- GPA 4.00-4.49 in both: 10% waiver.
- GPA 3.50-3.99 in both: 5% waiver.
- Below 3.50: 0% waiver.

Additional Waivers:
- 5% scholarship for females.
- 20% for Siblings.
- Special waiver for Freedom Fighters' wards.
- Authority reserves right to change fee structure.
- Admission test may be exempted based on combined GPA.
EOT;

        $geminiMessages = collect($this->messages)->map(function ($msg) {
            return [
                'role' => $msg['role'] === 'assistant' ? 'model' : 'user',
                'parts' => [
                    ['text' => $msg['content']]
                ],
            ];
        })->toArray();

        $apiKey = env('GEMINI_API_KEY');

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-3-flash-preview:generateContent?key={$apiKey}", [
                'contents' => $geminiMessages,
                'system_instruction' => [
                    'parts' => [
                        ['text' => $systemPrompt]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 1024,
                ],
            ]);

            if ($response->failed()) {
                throw new \Exception("Gemini API Error: " . ($response->json('error.message') ?? 'Unknown error'));
            }

            $this->currentResponse = $response->json('candidates.0.content.parts.0.text') ?? 'I apologize, but I am unable to process your request at this moment.';

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
        
        $this->currentResponse = ''; 
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
                    Admission Assistant
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
                    @if(empty($messages))
                        <div class="flex flex-col items-center justify-center h-full text-center text-gray-400 p-4">
                            <x-heroicon-o-chat-bubble-left-right class="h-12 w-12 mb-4 opacity-20" />
                            <p>Welcome to Northern University! How can I help you with admissions today?</p>
                        </div>
                    @endif

                    @foreach($messages as $msg)
                        <div class="flex {{ $msg['role'] === 'user' ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[80%] rounded-lg p-3 {{ $msg['role'] === 'user' ? 'bg-black text-white' : 'bg-gray-100 text-gray-900 dark:bg-gray-800 dark:text-gray-100' }}">
                                <p class="whitespace-pre-wrap text-sm">{{ $msg['content'] }}</p>
                            </div>
                        </div>
                    @endforeach
                    
                    <div wire:loading wire:target="getResponse" class="flex justify-start">
                        <div class="max-w-[80%] rounded-lg p-3 bg-gray-100 text-gray-900 dark:bg-gray-800 dark:text-gray-100">
                            <div class="flex space-x-2">
                                <div class="h-2 w-2 bg-gray-400 rounded-full animate-bounce"></div>
                                <div class="h-2 w-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                                <div class="h-2 w-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-3 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
                <form wire:submit="sendMessage" class="flex w-full gap-2">
                    <input
                        id="chat-input"
                        wire:model="input"
                        type="text"
                        placeholder="Type a message..."
                        class="flex-1 px-4 py-2 rounded-md border border-gray-300 shadow-sm focus:border-black focus:ring-0 focus:outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white sm:text-sm"
                        wire:loading.attr="disabled"
                        wire:target="sendMessage,getResponse"
                        autofocus
                    />
                    <button 
                        type="submit" 
                        class="p-2 bg-black text-white rounded-md hover:bg-gray-800 disabled:opacity-50 disabled:cursor-not-allowed"
                        wire:loading.attr="disabled"
                        wire:target="sendMessage,getResponse"
                    >
                        <x-heroicon-o-paper-airplane class="h-4 w-4" />
                    </button>
                </form>
            </div>
        </div>
    @endif
    
    <script>
        document.addEventListener('livewire:initialized', () => {
            const container = document.getElementById('chat-container');
            const inputField = document.getElementById('chat-input');
            
            const scrollToBottom = () => {
                if (container) {
                    setTimeout(() => {
                        container.scrollTop = container.scrollHeight;
                    }, 50);
                }
            };

            const focusInput = () => {
                if (inputField && !inputField.disabled) {
                    inputField.focus();
                }
            };

            // Initial focus and scroll
            scrollToBottom();
            focusInput();

            // Handle updates
            Livewire.on('chat-updated', () => {
                scrollToBottom();
                setTimeout(focusInput, 100);
            });

            // Re-focus when loading finishes
            Livewire.hook('morph.updated', ({ el, component }) => {
                if (container) {
                    const isAtBottom = container.scrollHeight - container.scrollTop <= container.clientHeight + 100;
                    if (isAtBottom) {
                       scrollToBottom();
                    }
                }
                
                // If the input was disabled and is now enabled, focus it
                if (inputField && !inputField.disabled) {
                    focusInput();
                }
            });
        });
    </script>
</div>
