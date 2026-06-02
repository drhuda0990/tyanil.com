<!DOCTYPE html>
<html lang="{{ $cv->language ?? 'en' }}">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #000;
            margin: 40px;
            font-size: 12px;
            direction: {{ $cv->language == 'ar' ? 'rtl' : 'ltr' }};
            text-align: {{ $cv->language == 'ar' ? 'right' : 'left' }};
        }

        h1 {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .contact {
            text-align: center;
            font-size: 11px;
            margin-bottom: 20px;
        }

        hr {
            border: 0;
            border-top: 1px solid #000;
            margin: 10px 0;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            text-transform: uppercase;
            font-weight: bold;
            font-size: 13px;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .job-title {
            font-weight: bold;
        }

        .job-header {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
        }

        .job-date {
            color: #555;
            font-style: italic;
        }

        ul {
            margin: 5px 0 0 15px;
            padding: 0;
        }

        li {
            margin-bottom: 3px;
        }

        .skills-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .skills-table td {
            width: 50%;
            padding: 4px 0;
        }

        .reference-item {
            margin-bottom: 6px;
        }

        .profile {
            text-align: justify;
        }

        .gray {
            color: #555;
        }

        /* RTL Fix for Flex */
        [dir="rtl"] .job-header {
            flex-direction: row-reverse;
        }
    </style>
</head>

<body dir="{{ $cv->language == 'ar' ? 'rtl' : 'ltr' }}">
    <!-- HEADER -->
    <h1>{{ $cv->name ?? 'Your Name' }}<br> {{ $cv->job ?? 'Your Job Title' }}</h1>
    <div class="contact">
        {{ $cv->location ?? 'Your Address' }} · {{ $cv->contact ?? 'Phone / Email' }}
    </div>

    <!-- PROFILE -->
    <div class="section">
        <div class="section-title"> {{ $cv->language == 'ar' ? 'الملخص الإحترافي' : 'Professional Summary' }}</div>
        <hr>
        <p>{{ $cv->profile_content ?? 'Write a short professional summary here.' }}</p>
    </div>

    <!-- EMPLOYMENT HISTORY -->
    @php
        $employment = $cv->sections->where('type', 'experience')->sortBy('order_num');
    @endphp
    @if ($employment->count())
        <div class="section">
            <div class="section-title"> {{ $cv->language == 'ar' ? 'الخبرة العلمية' : 'Work Experience' }} </div>
            <hr>
            @foreach ($employment as $section)
                <div class="job">
                    <div class="job-header">
                        <strong>{{ $section->title }} <span>{{ $section->date }}</span>
                            @if ($section->expert_level)
                                <strong class="gray">{{ $section->expert_level }}</strong>
                            @endif
                            @if ($section->url)
                                <a href="{{ $section->url }}" target="_blank">
                                    {{ $cv->language == 'ar' ? '[هنا]' : '[HERE]' }} </a>
                            @endif
                        </strong>
                        <br>
                        @if ($section->location)
                            <strong class="gray">{{ $section->location }}</strong>
                        @endif

                    </div>
                    @if ($section->content)
                        <ul>
                            {!! nl2br(e($section->content)) !!}
                        </ul>
                    @endif
                </div>
                <br>
                <br>
            @endforeach
        </div>
    @endif


    <!-- EDUCATION -->
    @php
        $education = $cv->sections->where('type', 'education')->sortBy('order_num');
    @endphp
    @if ($education->count())
        <div class="section">
            <div class="section-title"> {{ $cv->language == 'ar' ? 'التعليم' : 'Education' }} </div>

            <hr>
            @foreach ($education as $section)
                <div class="job">
                    <div class="job-header">
                        <strong>{{ $section->title }} <span>{{ $section->date }}</span>
                            @if ($section->expert_level)
                                <strong class="gray">{{ $section->expert_level }}</strong>
                            @endif
                            @if ($section->url)
                                <a href="{{ $section->url }}" target="_blank">
                                    {{ $cv->language == 'ar' ? '[هنا]' : '[HERE]' }} </a>
                            @endif
                        </strong>
                        <br>
                        @if ($section->location)
                            <strong class="gray">{{ $section->location }}</strong>
                        @endif

                    </div>
                    @if ($section->content)
                        <ul>
                            {!! nl2br(e($section->content)) !!}
                        </ul>
                    @endif
                </div>
                <br>
                <br>
            @endforeach
    @endif

    <!-- SKILLS -->
    @php
        $skills = $cv->sections->where('type', 'skills')->sortBy('order_num');
    @endphp
    @if ($skills->count())
        <div class="section">
            <div class="section-title"> {{ $cv->language == 'ar' ? 'المهارات' : 'Skills' }} </div>
            <hr>
            @foreach ($skills as $section)
                <div class="job">
                    <div class="job-header">
                        <strong>{{ $section->title }} <span>{{ $section->date }}</span>
                            @if ($section->expert_level)
                                <strong class="gray">{{ $section->expert_level }}</strong>
                            @endif
                            @if ($section->url)
                                <a href="{{ $section->url }}" target="_blank">
                                    {{ $cv->language == 'ar' ? '[هنا]' : '[HERE]' }} </a>
                            @endif
                        </strong>
                        <br>
                        @if ($section->location)
                            <strong class="gray">{{ $section->location }}</strong>
                        @endif

                    </div>
                    @if ($section->content)
                        <ul>
                            {!! nl2br(e($section->content)) !!}
                        </ul>
                    @endif
                </div>
                <br>
                <br>
            @endforeach
        </div>
    @endif
    @php
        $certificate = $cv->sections->where('type', 'certificates')->sortBy('order_num');
    @endphp
    @if ($certificate->count())
        <div class="section">
            <div class="section-title"> {{ $cv->language == 'ar' ? 'الشهادات' : 'Certificates' }} </div>
            <hr>
            @foreach ($certificate as $section)
                <div class="job">
                    <div class="job-header">
                        <strong>{{ $section->title }} <span>{{ $section->date }}</span>
                            @if ($section->expert_level)
                                <strong class="gray">{{ $section->expert_level }}</strong>
                            @endif
                            @if ($section->url)
                                <a href="{{ $section->url }}" target="_blank">
                                    {{ $cv->language == 'ar' ? '[هنا]' : '[HERE]' }} </a>
                            @endif
                        </strong>
                        <br>
                        @if ($section->location)
                            <strong class="gray">{{ $section->location }}</strong>
                        @endif

                    </div>
                    @if ($section->content)
                        <ul>
                            {!! nl2br(e($section->content)) !!}
                        </ul>
                    @endif
                </div>
                <br>
                <br>
            @endforeach
        </div>
    @endif
    @php
        $languages = $cv->sections->where('type', 'languages')->sortBy('order_num');
    @endphp
    @if ($languages->count())
        <div class="section">
            <div class="section-title"> {{ $cv->language == 'ar' ? 'اللغات' : 'Languages' }} </div>
            <hr>
            @foreach ($languages as $section)
                <div class="job">
                    <div class="job-header">
                        <strong>{{ $section->title }} <span>{{ $section->date }}</span>
                            @if ($section->expert_level)
                                <strong class="gray">{{ $section->expert_level }}</strong>
                            @endif
                            @if ($section->url)
                                <a href="{{ $section->url }}" target="_blank">
                                    {{ $cv->language == 'ar' ? '[هنا]' : '[HERE]' }} </a>
                            @endif
                        </strong>
                        <br>
                        @if ($section->location)
                            <strong class="gray">{{ $section->location }}</strong>
                        @endif

                    </div>
                    @if ($section->content)
                        <ul>
                            {!! nl2br(e($section->content)) !!}
                        </ul>
                    @endif
                </div>
                <br>
                <br>
            @endforeach
        </div>
    @endif
    @php
        $projects = $cv->sections->where('type', 'projects')->sortBy('order_num');
    @endphp
    @if ($projects->count())
        <div class="section">
            <div class="section-title"> {{ $cv->language == 'ar' ? 'المشاريع' : 'projects' }} </div>
            <hr>
            @foreach ($projects as $section)
                <div class="job">
                    <div class="job-header">
                        <strong>{{ $section->title }} <span>{{ $section->date }}</span>
                            @if ($section->expert_level)
                                <strong class="gray">{{ $section->expert_level }}</strong>
                            @endif
                            @if ($section->url)
                                <a href="{{ $section->url }}" target="_blank">
                                    {{ $cv->language == 'ar' ? '[هنا]' : '[HERE]' }} </a>
                            @endif
                        </strong>
                        <br>
                        @if ($section->location)
                            <strong class="gray">{{ $section->location }}</strong>
                        @endif

                    </div>
                    @if ($section->content)
                        <ul>
                            {!! nl2br(e($section->content)) !!}
                        </ul>
                    @endif
                </div>
                <br>
                <br>
            @endforeach
        </div>
    @endif
    <!-- REFERENCES -->
    @php
        $references = $cv->sections->where('type', 'references')->sortBy('order_num');
    @endphp
    @if ($references->count())
        <div class="section">
            <div class="section-title"> {{ $cv->language == 'ar' ? 'المراجع' : 'References' }} </div>
            <hr>
            <div class="references">
                @foreach ($references as $section)
                    <div class="job">
                        <div class="job-header">
                            <strong>{{ $section->title }} <span>{{ $section->date }}</span>
                                @if ($section->expert_level)
                                    <strong class="gray">{{ $section->expert_level }}</strong>
                                @endif
                                @if ($section->url)
                                    <a href="{{ $section->url }}" target="_blank">
                                        {{ $cv->language == 'ar' ? '[هنا]' : '[HERE]' }} </a>
                                @endif
                            </strong>
                            <br>
                            @if ($section->location)
                                <strong class="gray">{{ $section->location }}</strong>
                            @endif

                        </div>
                        @if ($section->content)
                            <ul>
                                {!! nl2br(e($section->content)) !!}
                            </ul>
                        @endif
                    </div>
                    <br>
                    <br>
                @endforeach
            </div>
        </div>
    @endif

</body>

</html>
