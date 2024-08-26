<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
@include('admin.includes.head')

<body class="cbp-spmenu-push">
    <div class="main-content">
        <div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
            @include('admin.includes.sidebar')
        </div>
        <!--left-fixed -navigation-->
        <div id="page-wrapper">
            <div class="main-page container-fluid">

                <x-table-title title="Notifaction List" bntText="Add Notifaction"
                    dataTargetModel="#addNotifactionsModal">
                </x-table-title>


                <div class="col-md-12 bg-white" style="padding-top: 20px;">
                    @if($Notifications->isEmpty())
                    <x-alert-info msg="No Notifaction found. Please add a new Notifaction."></x-alert-info>
                    @else
                    <x-data-table :items="$Notifications" :columns="$columns" :deleteAction="'deleteItem'" />
                    @endif
                </div>

                @include('admin.pages.notifaction.add')

            </div>
        </div>
        <!--footer-->
        <div class="footer">
            <p>&copy; 2018 Glance Design Dashboard. All Rights Reserved | Design by <a href="https://w3layouts.com/"
                    target="_blank">w3layouts</a></p>
        </div>
        <!--//footer-->
    </div>

    @include('admin.includes.footer')


</body>

</html>