<template>
    <div v-if="contact" class="page-wrapper d-flex flex-column">
        <div class="chat-header">
            <div class="d-flex align-items-center">
                <div class="avatar">
                    <img :src="`https://api.adorable.io/avatars/50/${contact.id}.png`" />
                </div>
                <div class="chatting-with">
                    Chatting with {{contact.first_name}}                           
                </div>
            </div>   
        </div>
        <div class="chat-content messages" ref="chatContent">
            <Messages :contact="contact" :messages="messages" />
        </div>
        <div class="chat-footer">
            <div class="input-group send-message">                    
                <textarea v-model="message" class="form-control" placeholder="Type your message..." @keydown.enter.exact.prevent="handleSendMessage"></textarea>
                <div class="input-group-append">
                  <span class="input-group-text btn-send" @click="sendMessage"><i class="fas fa-paper-plane"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div v-else class="page-wrapper d-flex ">
        <div class="select-a-contact text-center align-self-center">
            <span class="icon"><i class="fas fa-user-alt-slash"></i></span>
            <p>Select a Contact</p>
        </div>
    </div>
</template>

<script>

    import Messages from './Messages';

    export default {
        props:{
            contact: {
                type: Object,
                default: null
            },
            messages: {
                type: Array,
                default: []
            }
        },
        data(){
            return {
                message: ''
            }
        },
        methods:{
            sendMessage(){
                if(this.message == ''){
                    return;
                }

                axios.post('/messages/send', {
                    to: this.contact.id,
                    message: this.message
                }).then( (response) => {                    
                    this.$emit('new-message', response.data);
                    this.scrollToBottom();
                });
                
                this.message = '';                
            },
            scrollToBottom(){
                setTimeout( () => {
                    this.$refs.chatContent.scrollTop = this.$refs.chatContent.scrollHeight - this.$refs.chatContent.clientHeight;
                }, 50)
            },
            handleSendMessage(e){
                this.sendMessage();
            }
        },
        watch: {
            messages(messages){
                this.scrollToBottom();
            }
        },
        components: {Messages}
    }
</script>