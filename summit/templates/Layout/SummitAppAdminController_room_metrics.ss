<div id="wrapper">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <% include SummitAdmin_SidebarMenu AdminLink=$Top.Link, SummitID=$Summit.ID, Active='room_metrics' %>
    </div><!-- /#sidebar-wrapper -->
    <!-- Page Content -->
    <div id="page-content-wrapper" class="reports-wrapper">
        <ol class="breadcrumb">
            <li><a href="$Top.Link">Home</a></li>
            <li><a href="$Top.Link/{$Summit.ID}/dashboard">$Summit.Name</a></li>
            <li><a href="$Top.Link/{$Summit.ID}/reports">Reports</a></li>
            <li class="active">Room Metrics</li>
        </ol>

        <script type="application/javascript">
            var events = [];
            <% loop $Events %>
                events.push({
                    id: $ID,
                    title: "{$getTitleAndTime().JS}",
                    location: "{$getLocationNameNice().JS}",
                    capacity: "{$getLocationCapacity()}",
                });
            <% end_loop %>

        </script>
        <room-metrics-container summit_id="{ $Summit.ID }" events="{ events }" ></room-metrics-container>

    </div>
</div>

<script src="summit/javascript/schedule/admin/room-metrics-view.bundle.js?t={$Top.Time}" type="application/javascript"></script>