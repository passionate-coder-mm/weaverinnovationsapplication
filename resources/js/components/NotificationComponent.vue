<template>
          <li class="dropdown notifications-menu" id="notifications">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">{{allnotifications.length}}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have {{allnotifications.length}} notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul   id="notifications-body">
                  <li v-for="notification in allnotifications">
                    <a href="#" v-on:click="markasread(notification)"> 
                        <small>{{notification.data.leave.purpose}}</small>
                      </a>
                  </li>
                  <li v-if="allnotifications.length == 0">
                     No Request Found
                   </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
</template>

<script>
    export default {
       
           props:['allnotifications'],
           methods:
                {
                markasread:function(notification){
                    var data = {
                        id: notification.id
                    };
                    axios.post('leave/notification/read',data).then(response=>{
                    window.location.href = "/leave/leaveapproval/"+notification.data.leave.id+"/"+notification.data.leave.uniqueidentification;
                    });
                 }           
           }
          //  mounted() {
          //    Echo.private('App.User.' + this.userid)
          //   .notification((notification) => {
          //       console.log(notification);
          //   });
          //  },
     
    }
</script>
