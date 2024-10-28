<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\News;
use App\Models\Notice;
use App\Models\Slider;
use App\Models\Staff;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        // Cache frequently accessed data for 60 days
        $sliders = Cache::remember('sliders', 60, function () {
            return Slider::where('status', 1)->orderBy('id', 'desc')->get();
        });

        $all_notice = Cache::remember('notices', 60, function () {
            return Notice::where('status', 1)->orderBy('id', 'desc')->paginate(10);
        });

        $all_event = Cache::remember('events', 60, function () {
            return Event::where('status', 1)->orderBy('id', 'desc')->paginate(3);
        });

        $all_news = Cache::remember('news', 60, function () {
            return News::where('status', 1)->orderBy('id', 'desc')->paginate(3);
        });

        return view('frontend.layouts.home', compact('sliders', 'all_notice', 'all_event', 'all_news'));
    }

    public function contactUs()
    {
        return view('frontend.contact.contact_us');
    }

    public function singleNotice($slug)
    {
        // Remove unnecessary orderBy for a single result
        $notice = Notice::where('slug', $slug)->firstOrFail();

        // Cache notices to reduce database load
        $all_notice = Cache::remember('all_notices', 60, function () {
            return Notice::where('status', 1)->orderBy('id', 'desc')->paginate(10);
        });

        return view('frontend.notice.single_notice', compact('notice', 'all_notice'));
    }

    public function allNotice()
    {
        $all_notice = Cache::remember('all_notices_paginated', 60, function () {
            return Notice::where('status', 1)->orderBy('id', 'desc')->paginate(10);
        });

        return view('frontend.notice.all_notice', compact('all_notice'));
    }

    public function singleEvent($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        $all_event = Cache::remember('all_events', 60, function () {
            return Event::where('status', 1)->orderBy('id', 'desc')->paginate(10);
        });

        return view('frontend.event.single_event', compact('event', 'all_event'));
    }

    public function allEvent()
    {
        $all_event = Cache::remember('all_events_paginated', 60, function () {
            return Event::where('status', 1)->orderBy('id', 'desc')->paginate(10);
        });

        return view('frontend.event.all_event', compact('all_event'));
    }

    public function gallery()
    {
        return view('frontend.gallery.gallery');
    }

    public function singleNews($slug)
    {
        $news = News::where('slug', $slug)->firstOrFail();

        $all_news = Cache::remember('all_news', 60, function () {
            return News::where('status', 1)->orderBy('id', 'desc')->paginate(10);
        });

        return view('frontend.news.single_news', compact('news', 'all_news'));
    }



    public function allNews()
    {
        $all_news = Cache::remember('all_news_paginated', 60, function () {
            return News::where('status', 1)->orderBy('id', 'desc')->paginate(10);
        });

        return view('frontend.news.all_news', compact('all_news'));
    }

    public function allStaff()
    {
        $all_staff = Cache::remember('all_staff', 60, function () {
            return Staff::where('status', 1)->orderBy('id', 'desc')->paginate(10);
        });

        return view('frontend.staff.all_staff', compact('all_staff'));
    }

    public function chairmanMsg()
    {
        return view('frontend.msg.message_form_chairman');
    }

    public function directorMsg()
    {
        return view('frontend.msg.message_form_director');
    }

    public function historyOfBbbr()
    {
        return view('frontend.history.brr_history');
    }

    public function guideLines()
    {
        return view('frontend.guideline.guide_lines');
    }

    public function publication()
    {
        return view('frontend.publication.publication');
    }
    public function researchTeam()
    {
        return view('frontend.research.research_team');
    }
    public function chairmanDirectorList()
    {
        return view('frontend.organogram.organogram');
    }

    public function trainingAndDevelopment()
    {
        return view('frontend.training.development');
    }

    public function researchMethodologyTraining()
    {
        return view('frontend.training.research_methodology_training');
    }

    public function softwareTraining()
    {
        return view('frontend.training.research_methodology_training');
    }
    public function consultancyAndIndustrialProblemSolving()
    {
        return view('frontend.training.research_methodology_training');
    }
    public function corporateTraining()
    {
        return view('frontend.training.corporate_training');
    }
    public function ongoingProjects()
    {
        return view('frontend.training.on_going_projects');
    }

    public function listOfTheCommittee()
    {
        return view('frontend.listOfTheCommittee.list_of_the_committee');
    }
}
