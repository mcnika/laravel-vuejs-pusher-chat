<template>
    <ul class="contacts list-unstyled" v-if="contacts">
        <li v-for="contact in contacts" :key="contact.id" @click="selectContact(contact)">
            <div :class="{ 'd-flex' : true, 'selected' : selectedContact==contact }">
                <span class="contact-avatar avatar">
                    <img :src="`https://api.adorable.io/avatars/50/${contact.id}.png`" alt="" />
                </span>
                <span class="contact-info">
                    <span class="contact-name">{{contact.first_name}}</span>
                    <span v-if="contact.latest_message">{{contact.latest_message}}</span>
                </span>
                <span class="ml-auto" v-if="contact.unread">
                    <span class="badge badge-success badge-pill">{{contact.unread}}</span>
                </span>
            </div>
        </li>
    </ul>
</template>

<script>
    export default {
        props:{
            contacts:{
                type: Array,
                default: []
            }
        },
        data(){
            return {
                selectedContact: null
            }
        },
        methods:{
            selectContact(contact){
                this.selectedContact = contact;
                this.$emit('selected-contact', contact);
            }
        }    
    }
</script>