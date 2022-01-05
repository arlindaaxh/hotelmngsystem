export default {
    mode:'history',
    routes:[
        {
            path: '/',
            component: () => import('./views/Home'),
            name: 'home'
        },
        {
            path: '/about',
            component: () => import('./views/About'),
            name: 'About'
        },
        {
            path: '/administration',
            component: () => import('./views/administration/Administration'),
            name: 'administration',
            children: [
                {
                    path: '/dashboard',
                    component: () => import('./components/administration/Dashboard'),
                    name: 'dashboard'
                },
                {
                    path: '/employees',
                    component: () => import('./views/administration/Employees'),
                    name: 'employees',
                    children: [
                        {
                            path:'/add-employee',
                            component: () => import('./components/administration/employees/AddEditEmployees'),
                            name: 'add-employee',
                            props: (route) => ({
                                ...route.params
                            })
                        },
                        {
                            path:'/edit-employee/:id',
                            component: () => import('./components/administration/employees/AddEditEmployees'),
                            name: 'edit-employee',
                            props: (route) => ({
                                ...route.params
                            })
                        },
                    ]
                },
                {
                    path: '/departments',
                    component: () => import('./views/administration/Departments'),
                    name: 'departments'
                },
                {
                    path: '/rooms',
                    name: 'rooms',
                    component: () => import('./views/administration/Rooms'),
                    children: [
                        {
                            path:'/add-room',
                            component: () => import('./components/administration/rooms/AddEditRoom'),
                            name: 'add-room',
                            props: (route) => ({
                                ...route.params
                            })
                        },
                        {
                            path:'/edit-room/:id',
                            component: () => import('./components/administration/rooms/AddEditRoom'),
                            name: 'edit-room',
                            props: (route) => ({
                                ...route.params
                            })
                        },
                    ]
                },
                {
                    path: '/addons',
                    name: 'addons',
                    component: () => import('./views/administration/Addons')
                }
            ]
        },
        {
            path: '/frontdesk',
            name: 'frontdesk',
            component: () => import('./views/frontdesk/Frontdesk'),
            children: [
                {
                    path: '/frontdesk-dashboard',
                    component: () => import('./views/frontdesk/Dashboard'),
                    name: 'frontdesk-dashboard',
                    children: [
                        {
                            path: '/new-booking',
                            component: () => import('./components/frontdesk/dashboard/NewBooking'),
                            name: 'new-booking'
                        }
                    ]
                },
                {
                    path: '/housekeeping',
                    component: () => import('./components/frontdesk/Housekeeping'),
                    name: 'housekeeping'
                },
                {
                    path: '/in-house',
                    component: () => import('./views/frontdesk/InHouse'),
                    name: 'in-house'
                },
                {
                    path: '/departures',
                    component: () => import('./views/frontdesk/Departures'),
                    name: 'departures'
                },
                {
                    path: '/availability',
                    component: () => import('./views/frontdesk/Availability'),
                    name: 'availability'
                },
                {
                    path: '/reservations-list',
                    component: () => import('./views/frontdesk/ReservationsList'),
                    name: 'reservations-list',
                    children: [
                        {
                            path: '/reservation-details',
                            component: () => import('./components/frontdesk/reservations-list/ReservationDetails'),
                            name: 'reservation-details',
                            props: (route) => ({
                                ...route.params
                            })
                        }
                    ]
                },

            ]
        }

       

    ]
}