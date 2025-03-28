@extends('frontend.layouts.master')

@section('title', 'Investment Proposal')

@section('content')
    <div class="py-10 px-5">
        <div class="mt-10 mb-5 mx-auto rounded-lg p-8">
            <h1 class="text-4xl font-bold text-gray-700 mb-8 text-center">Investment Proposal</h1>

            <div class="flex flex-wrap justify-center text-white">
                @forelse ($investmentProposals as $investmentProposal)
                    <div class="main-bg-color m-2 shadow-md rounded-lg p-4 flex flex-col h-full w-full sm:w-full lg:w-[48%] xl:w-[48%]">
                        <h2 class="text-xl mb-2"><span class="font-semibold">Project Title: </span>{{ $investmentProposal->project_name }}</h2>
                        @if(trim($investmentProposal->project_details) !== '')
                            <div class="project-details">
                                <p class="mt-2">
                                    <span class="font-semibold">Project Details:</span>
                                    <span class="short-text">{{ Str::limit($investmentProposal->project_details, 100) }}</span>
                                    <span class="full-text hidden">{{ $investmentProposal->project_details }}</span>
                                    @if (strlen($investmentProposal->project_details) > 100)
                                        <a href="#" class="text-green-500 see-more">See More</a>
                                    @endif
                                </p>
                            </div>
                        @endif

                        <!-- Optional YouTube Video URL -->
                        <div class="py-4">
                            @if ($investmentProposal->video)
                                @php
                                    $videoUrl = $investmentProposal->video;

                                    // Check if it's a standard YouTube URL
                                    if (strpos($videoUrl, 'youtube.com/watch?v=') !== false) {
                                        $videoId = substr($videoUrl, strpos($videoUrl, 'v=') + 2, 11);
                                        $embedUrl = "https://www.youtube.com/embed/$videoId";
                                    }
                                    // Check if it's a shortened YouTube URL
                                    elseif (strpos($videoUrl, 'youtu.be/') !== false) {
                                        $videoId = substr($videoUrl, strrpos($videoUrl, '/') + 1);
                                        $embedUrl = "https://www.youtube.com/embed/$videoId";
                                    } else {
                                        $embedUrl = null;  // If it's not a valid YouTube URL
                                    }
                                @endphp

                                @if ($embedUrl)
                                    <iframe class="rounded-lg w-full mx-auto text-center" width="500" height="315" src="{{ $embedUrl }}" allowfullscreen></iframe>
                                @else
                                    <p>Invalid video URL</p>
                                @endif
                            @else
                                N/A
                            @endif
                        </div>

                        <!-- Apply Now Button (Link to specific proposal view) -->
                        <div class="mt-auto">
                            <a href="{{ route('frontend.pages.investment.applicants.create', ['id' => $investmentProposal->id]) }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Interested
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 sm:col-span-2 lg:col-span-2 text-center">
                        <p class="text-gray-500">No investment proposals found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Toggle full text display
            $('.see-more').on('click', function(e) {
                e.preventDefault();
                const $this = $(this);
                const $details = $this.closest('.project-details');
                $details.find('.short-text').toggle();
                $details.find('.full-text').toggle();
                $this.text($details.find('.full-text').is(':visible') ? 'See Less' : 'See More');
            });

            @if (session('success'))
                toastr.success('{{ session('success') }}', 'Success', {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 5000
                });
            @endif

            @if (session('error'))
                toastr.error('{{ session('error') }}', 'Error', {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 5000
                });
            @endif
        });
    </script>
@endsection
