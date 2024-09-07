<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
@include('admin.includes.head')

<body class="cbp-spmenu-push">
    <div class="main-content">

        @include('admin.includes.sidebar')


        <div id="page-wrapper">
            <div class="main-page container-fluid">

                <h5>Group List</h5>

                <div class="col-md-12 bg-white" style="padding-top: 20px;">

                    @if($Groups->isEmpty())
                    <x-alert-info msg="No Group Found. Please add a new Group."></x-alert-info>
                    @else
                    <x-data-table :items="$Groups" :columns="$columns" :deleteAction="'groups'" />
                    @endif

                </div>
            </div>
        </div>

        @include('admin.pages.user.add')
    </div>

    @include('admin.includes.footer')




</body>



</html>