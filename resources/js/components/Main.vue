<template>
    <div class="wrapper">
        <div class="sidebar d-flex flex-column">
            <div class="sidebar-header">
                <div class="dropdown show">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Welcome {{ user.first_name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="#" @click="logout">Logout</a>
                        <form ref="logoutForm" :action="logoutRoute" method="POST" style="display: none;">
                           <input type="text" name="_token" v-model="token"  />
                        </form>
                    </div>
                </div>
            </div>
            <div class="sidebar-content">
                <Contacts :contacts="contacts" @selected-contact="openChat" />
            </div>            
        </div>
        <Chat :contact="selectedContact" :messages="messages" @new-message="pushMessage" />
    </div>    
</template>

<script>
    import Contacts from './parts/Contacts';
    import Chat from './parts/Chat';

    export default{
        props:{
            user:{
                type: Object,
                required: true
            },
            logoutRoute:{
                type: String,
                required: true
            }
        },
        data(){
            return {
                contacts: [],
                messages: [],
                selectedContact: null,
                token: ''
            }
        },
        mounted() {
            this.token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
           
            Echo.private(`chanel.messages.${this.user.id}`)
                .listen('SendMessage', (e) => {                    
                    this.incomingMessage(e.message);                    
            });

            axios.get('/contacts')
                .then( (response) => {
                    this.contacts = response.data;                                   
                });
        },
        methods:{
            openChat(contact){ 
                this.updateContactList(contact, '', true);
                axios.get(`/messages/${contact.id}`)
                    .then( (response) => {
                        this.messages = response.data;  
                        this.selectedContact = contact;  
                    });               
            },
            pushMessage(message){                     
                this.messages.push(message);               
            },
            updateContactList(selectedContact, message, reset){
                var index = this.contacts.findIndex(contact => contact.id === selectedContact.id);                
                if(reset){
                    this.contacts[index].unread = 0;   
                } else {
                    this.contacts[index].unread++; 
                    this.playSound();
                }

                if(message){
                    this.contacts[index].latest_message = message;   
                }
                
            },
            incomingMessage(message){               
                if(this.selectedContact && this.selectedContact.id == message.from_id){
                    this.pushMessage(message);                   
                    this.updateContactList(message.user, message.message, true); 
                    axios.get(`/read/${message.from_id}`); 
                    return;    
                }  
                this.updateContactList(message.user, message.message, false);
            },
            playSound(){
                var audio = new Audio('/audio/Bing-sound.mp3');
                audio.play();
            },
            logout(e){               
                e.preventDefault();
                this.$refs.logoutForm.submit();
            }
        },
        components: {Contacts, Chat}
    }
</script>