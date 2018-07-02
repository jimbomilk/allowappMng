<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">

    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab">Ayuda</a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab">Preguntas frecuentes</a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane active" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Ayuda de {{trans("labels.$name")}}</h3>
            <div class="form-group">
                <label class="control-sidebar-subheading">
                    {{trans("help.$name.title1")}}
                </label>
                <p>
                    {!!trans("help.$name.text1")!!}
                </p>
                @if (trans("help.$name.title2") != "help.$name.title2")
                    <label class="control-sidebar-subheading">
                        {{trans("help.$name.title2")}}
                    </label>
                    <p>
                        {!!trans("help.$name.text2")!!}
                    </p>
                @endif
                @if (trans("help.$name.title3") != "help.$name.title3")
                    <label class="control-sidebar-subheading">
                        {{trans("help.$name.title3")}}
                    </label>
                    <p>
                        {!!trans("help.$name.text3")!!}
                    </p>
                @endif
                @if (trans("help.$name.title4") != "help.$name.title4")
                    <label class="control-sidebar-subheading">
                        {{trans("help.$name.title4")}}
                    </label>
                    <p>
                        {!!trans("help.$name.text4")!!}
                    </p>
                @endif
            </div><!-- /.form-group -->

        </div><!-- /.tab-pane -->
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">{{ trans('adminlte_lang::message.statstab') }}</div><!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
            <h3 class="control-sidebar-heading">Preguntas sobre {{trans("labels.$name")}}</h3>
            <div class="form-group">
                <label class="control-sidebar-subheading">
                    {{trans("help.$name.question1")}}
                </label>
                <p>
                    {!!trans("help.$name.answer1")!!}
                </p>
                @if (trans("help.$name.question2") != "help.$name.question2")
                    <label class="control-sidebar-subheading">
                        {{trans("help.$name.question2")}}
                    </label>
                    <p>
                        {!!trans("help.$name.answer2")!!}
                    </p>
                @endif
                @if (trans("help.$name.question3") != "help.$name.question3")
                    <label class="control-sidebar-subheading">
                        {{trans("help.$name.question3")}}
                    </label>
                    <p>
                        {!!trans("help.$name.answer3")!!}
                    </p>
                @endif
                @if (trans("help.$name.question4") != "help.$name.question4")
                    <label class="control-sidebar-subheading">
                        {{trans("help.$name.question4")}}
                    </label>
                    <p>
                        {!!trans("help.$name.answer4")!!}
                    </p>
                @endif
            </div><!-- /.form-group -->

        </div><!-- /.tab-pane -->
    </div>



</aside><!-- /.control-sidebar

<!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
<div class='control-sidebar-bg'></div>