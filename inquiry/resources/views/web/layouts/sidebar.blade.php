<div class="col-2 wizard-sidebar">
    <nav>

        @if($exist == null)
            <style>
                .disable-side {
                    pointer-events: none;
                }
            </style>
        @endif

        <ul>
            <li class="nav-item  {{($name == 1) ? 'active-nav': ''}}"><a class="nav-link"
                                                                                      href="{{url(isset($url) ? $url: null)}}"><i
                            class="fa fa-envelope-o"></i> Email</a></li>

            <li class="nav-item  {{($name == 7) ? 'active-nav': ''}}"><a class="nav-link"
                                                                                     href="{{url(isset($url) ? $url: null)}}"><i
                            class="fa fa-pencil-square-o"></i> Title</a></li>
            <li class="nav-item disable-side  {{($name == 3) ? 'active-nav': ''}}"><a class="nav-link"
                                                                                      href="{{url('detail',isset($exist) ?['project_id', $exist->id] : null)}}"><i
                            class="fa fa-th"></i> Details</a></li>
            <li class="nav-item disable-side  {{($name == 2) ? 'active-nav': ''}}"><a class="nav-link"
                                                                                      href="{{url('description', isset($exist) ?['project_id', $exist->id] : null)}}"><i
                            class="fa fa-file-text-o"></i>
                    Description</a></li>
            <li class="nav-item disable-side {{($name == 4) ? 'active-nav': ''}}"><a class="nav-link"
                                                                                     href="{{url('question',isset($exist) ?['project_id', $exist->id] : null)}}"><i
                            class="fa fa-question-circle"></i>
                    Questions</a>
            </li>
            <li class="nav-item disable-side {{($name == 5) ? 'active-nav': ''}}"><a class="nav-link"
                                                                                     href="{{url('expertise',isset($exist) ?['project_id', $exist->id] : null)}}"><i
                            class="fa fa-thumbs-o-up"></i>
                    Expertise</a>
            </li>
            <li class="nav-item disable-side {{($name == 6) ? 'active-nav': ''}}"><a class="nav-link"
                                                                                     href="{{url('budget',isset($exist) ?['project_id', $exist->id] : null)}}"><i
                            class="fa fa-usd"></i> Budget</a></li>
            <li class="nav-item disable-side  {{($name == 9) ? 'active-nav': ''}}"><a class="nav-link"
                                                                                      href="{{url('review',isset($exist) ?['project_id', $exist->id] : null)}}"><i
                            class="fa fa-check"></i> Review</a>
            </li>
        </ul>
    </nav>
</div>
