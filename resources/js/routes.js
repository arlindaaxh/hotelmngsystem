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
                            path:'/edit-employee',
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
                }
            ]
        },
       

    ]
}