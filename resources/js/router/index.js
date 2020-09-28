import Vue from "vue";
import Router from "vue-router";

import Dashboard from '../pages/dashboard/Dashboard';
import Settings from '../pages/Settings';
import Users from '../pages/Users';
import Roles from '../pages/Roles';
import Permissions from '../pages/Permissions';
import PageNotFound from '../pages/PageNotFound';
import Brands from '../pages/brand/Brands';
import Categories from '../pages/category/Categories';
import Customers from '../pages/customer/Customers';
import CustomerDetail from '../pages/customer/CustomerDetail';
import Distributors from '../pages/distributor/Distributors';
import Products from '../pages/product/Products';
import Invoices from '../pages/invoice/Invoices';
import InvoicePreview from '../pages/invoice/InvoicePreview';
import Stocks from '../pages/stock/Stocks';
import StockForm from '../pages/stock/StockForm';
import ShowStock from '../pages/stock/ShowStock';
import InvoiceForm from '../pages/invoice/InvoiceForm';
import ShowInvoice from '../pages/invoice/ShowInvoice';
import Inventories from '../pages/inventory/Inventories';


Vue.use(Router);

export default new Router({
  mode:'history',
  routes: [
    {
        path: '/app',
        component:Dashboard,
        name:'dashboard'
    },
    {
        path:'/customers',
        component: Customers,
        name:'customers'
    },
    {
        path:'/customer/:id',
        component:CustomerDetail,
        name:'customerdetail'
    },
    {
        path:'/distributors',
        component: Distributors,
        name:'distributors'
    },
    {
        path:'/brands',
        component: Brands,
        name:'brands'
    },
    {
        path:'/categories',
        component: Categories,
        name:'categories'

    },
   
    {
        path:'/invoices/new',
        component:InvoiceForm,
        name:'invoice-form'
    },
    {
        path:'/invoices',
        component: Invoices,
        name:'invoices'
    },
    {
        path:'/invoices/:id',
        component:ShowInvoice,
        name:'showInvoice'
    },
    {
        path:'/invoices/preview',
        component:InvoicePreview,
        name:'InvoicePreview',
        props:{
            invoice:{
                
            }
        }
    },
   
    
    {
        path:'/products',
        component: Products,
        name:'products'
    },
    {
        path:'/stocks/new',
        component: StockForm,
        name:'Stock-Form'
    },
    {
        path:'/stocks',
        component: Stocks,
        name:'stocks'
    },
   
    {
        path:'/stocks/:id',
        component:ShowStock,
        name:'showStock'
    },
    {
        path:'/inventories',
        component: Inventories,
        name:'inventories'
    },

    {
        path: '*',
        component:PageNotFound
    },


    // {
    //     path:'/users',
    //     component:Users
    // },
    // {
    //     path:'/roles',
    //     component:Roles
    // },
    // {
    //     path:'/permissions',
    //     component:Permissions
    // },
    // {
    //     path:'/settings',
    //     component:Settings
    // },
    
  ]
});
