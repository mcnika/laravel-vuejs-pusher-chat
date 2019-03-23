<template>
    <div class="chat-content-inner">
        <div v-for="message in messages" :class="`d-flex mb-4${contact.id == message.from_id ? ' justify-content-start' : ' justify-content-end'}`">
            <div class="avatar">
                <img :src="`https://api.adorable.io/avatars/40/${ message.from_id}.png`" />
            </div>
            <div class="message-details">                             
                <span class="message">{{message.message}}</span>
                <span class="time">{{ message.created_at | moment }}</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        props: {
            contact: {
                type: Object
            },
            messages: {
                type: Array,
                required: true
            }
        },
        filters:{
            moment: function(date){               
                return moment(date).format('MMM DD, YYYY h:mm');                
            }
        }
    }    
</script>