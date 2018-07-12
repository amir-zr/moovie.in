var httpService= myApp.service("httpService",function () {
   this.post=function (url,params,config) {
       //var args=new URLSearchParams();
       /*Object.keys(params).forEach(function (item) {
           args.append(item,params[item]);
       });*/
       return axios.post(url,params,config);
   } ;
   this.get=function (url,params) {
       return axios.get(url,{
           params:params
       });
   }
});