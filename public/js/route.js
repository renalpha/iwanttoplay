angular.module('website', ['ngRoute']).
    config(function ($routeProvider) {
        $routeProvider.
            when('/dashboard', {templateUrl: 'pages/dashboard.html'}).
            when('/extra/login', {templateUrl: 'pages/extra/login.html'}).
            when('/charts/rich-charts', {templateUrl: 'pages/charts/rich-charts.html'}).
            when('/extra/signup', {templateUrl: 'pages/extra/signup.html'}).
            when('/extra/pattern', {templateUrl: 'pages/extra/pattern-login.html'}).
            when('/extra/widgets', {templateUrl: 'pages/extra/widgets.html'}).
            when('/extra/blog', {templateUrl: 'pages/extra/blog.html'}).
            when('/extra/single-post', {templateUrl: 'pages/extra/single-post.html'}).
            when('/dashboard-2', {templateUrl: 'pages/dashboard-2.html'}).
            when('/dashboard-3', {templateUrl: 'pages/dashboard-3.html'}).
            when('/mail/inbox', {templateUrl: 'pages/mail/inbox.html'}).
            when('/mail/compose', {templateUrl: 'pages/mail/compose.html'}).
            when('/personal/profile', {templateUrl: 'pages/personal/profile.html'}).
            when('/ui/buttons', {templateUrl: 'pages/ui/buttons.html'}).
            when('/ui/timeline', {templateUrl: 'pages/ui/timeline.html'}).
            when('/ui/panels', {templateUrl: 'pages/ui/widget-panel.html'}).
            when('/extra/404', {templateUrl: 'pages/extra/404.html'}).
            when('/extra/505', {templateUrl: 'pages/extra/505.html'}).
            when('/extra/faq', {templateUrl: 'pages/extra/faq.html'}).
            when('/extra/portfolio-2', {templateUrl: 'pages/extra/portfolio-2.html'}).
            when('/extra/portfolio-3', {templateUrl: 'pages/extra/portfolio-3.html'}).
            when('/extra/search', {templateUrl: 'pages/extra/search.html'}).
            when('/extra/no-result', {templateUrl: 'pages/extra/not-found.html'}).
            when('/extra/scrollbox', {templateUrl: 'pages/extra/scrollbox.html'}).
            when('/extra/service', {templateUrl: 'pages/extra/services.html'}).
            when('/extra/contact', {templateUrl: 'pages/extra/contact.html'}).
            when('/extra/members', {templateUrl: 'pages/extra/members.html'}).
            when('/extra/lockscreen', {templateUrl: 'pages/extra/lockscreen.html'}).
            when('/extra/reset', {templateUrl: 'pages/extra/reset.html'}).
            when('/extra/about', {templateUrl: 'pages/extra/about.html'}).
            when('/extra/soon', {templateUrl: 'pages/extra/coming-soon.html'}).
            when('/extra/google-map', {templateUrl: 'pages/extra/google-map.html'}).
            when('/extra/invoice', {templateUrl: 'pages/extra/invoice.html'}).
            when('/ui/range', {templateUrl: 'pages/ui/range.html'}).
            when('/ui/sort', {templateUrl: 'pages/ui/sortable.html'}).
            when('/ui/tables', {templateUrl: 'pages/ui/tables.html'}).
            when('/ui/tabular-table', {templateUrl: 'pages/ui/tabular-table.html'}).
            when('/ui/task', {templateUrl: 'pages/ui/task.html'}).
            when('/ui/progress', {templateUrl: 'pages/ui/progress-bar.html'}).
            when('/ui/task-2', {templateUrl: 'pages/ui/task2.html'}).
            when('/ui/popovers', {templateUrl: 'pages/ui/popovers.html'}).
            when('/ui/calculator', {templateUrl: 'pages/ui/calculator.html'}).
            when('/ui/navbars', {templateUrl: 'pages/ui/navbars.html'}).
            when('/ui/typography', {templateUrl: 'pages/ui/typography.html'}).
            when('/ui/prices', {templateUrl: 'pages/ui/prices.html'}).
            when('/ui/calendar', {templateUrl: 'pages/ui/calendar.html'}).
            when('/ui/upload-crop', {templateUrl: 'pages/ui/upload-crop.html'}).
            when('/ui/tour', {templateUrl: 'pages/ui/tour.html'}).
            when('/ui/collapse', {templateUrl: 'pages/ui/collapse.html'}).
            when('/ui/form', {templateUrl: 'pages/ui/form.html'}).
            when('/ui/grids', {templateUrl: 'pages/ui/grids.html'}).
            when('/ui/font-awesome', {templateUrl: 'pages/ui/font-awesome.html'}).
            when('/ui/line-icons', {templateUrl: 'pages/ui/line-icons.html'}).
            when('/layouts/nav-light', {templateUrl: 'pages/layouts/nav-light.html'}).
            when('/layouts/blank', {templateUrl: 'pages/layouts/blank.html'}).
            when('/layouts/vertical-menu', {templateUrl: 'pages/layouts/vertical-menu.html'}).
            when('/ui/notification', {templateUrl: 'pages/ui/notification.html'}).
            otherwise({redirectTo: '/dashboard'});
    })
