<template>
    <grid :position="grid" modifiers="social-media padded fa fa-bars fa-sort-desc">
        <section class="social">
            <h1 class="social__title">Social Media <span>Stats</span></h1>
            <div class="social__content" title="Facebook Likes Count">
                <i class="fa fa-facebook circular-social"></i>
                <span :class="{ 'social-up-statistics__count': isFacebookUp(), 'social-down-statistics__count': !isFacebookUp()}">
                    <i :class="{ 'fa fa-angle-up': isFacebookUp(), 'fa fa-angle-down': !isFacebookUp() }"></i>
                    {{ events.facebook_likes_count}}
                </span>
            </div>

            <div class="social__content" title="Twitter Followers Count">
                <i class="fa fa-twitter circular-social" aria-hidden="true"></i>
                <span :class="{ 'social-up-statistics__count': isTwitterUp(), 'social-down-statistics__count': !isTwitterUp()}"> 
                    <i :class="{ 'fa fa-angle-up': isTwitterUp(), 'fa fa-angle-down': !isTwitterUp() }"></i>
                    {{ events.twitter_followers_count }}
                </span>
            </div>

            <div class="social__content" title="Linkedin Share count">
                <i class="fa fa-linkedin circular-social" aria-hidden="true"></i>
                <span :class="{ 'social-up-statistics__count': isInUp(), 'social-down-statistics__count': !isInUp()}"> 
                    <i :class="{ 'fa fa-angle-up': isInUp(), 'fa fa-angle-down': !isInUp() }"></i>
                    {{ events.Website_in_share_count }}
                </span>
            </div>

            <div class="social__content" title="Youtube Subscriber Count">
                <i class="fa fa-youtube circular-social" aria-hidden="true"></i>
                <span :class="{ 'social-up-statistics__count': isYouUp(), 'social-down-statistics__count': !isYouUp()}"> 
                    <i :class="{ 'fa fa-angle-up': isYouUp(), 'fa fa-angle-down': !isYouUp() }"></i>
                    {{ events.youtube_subscribers_count }}
                </span>
            </div>
        </section>
    </grid>
</template>

<script>
import echo from '../mixins/echo';
import Grid from './Grid';
import saveState from 'vue-save-state';

export default {

    components: {
        Grid,
    },

    mixins: [echo, saveState],

    props: ['grid'],

    data() {
        return {
            events: [],
            current_twitter_followers: 2180,
            current_facebook_likes_count: 1020,
            current_in_share_count: 10,
            current_you_subscribers: 32
        };
    },

    mounted(){
        // console.log(this.isFacebookUp());
        console.log(this.isTwitterUp());
    },

    methods: {
        getEventHandlers() {
            return {
                'SocialMedia.EventsFetched': response => {
                    this.events = response.events
                },
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'social-media',
            };
        },

        isFacebookUp() {
            return this.events.facebook_likes_count >= this.current_facebook_likes_count;
        },

        isTwitterUp() {
            return this.events.twitter_followers_count >= this.current_twitter_followers;
        },
        isInUp() {
            return this.events.Website_in_share_count >= this.current_in_share_count;
        },
        isYouUp() {
            return this.events.youtube_subscribers_count >= this.current_you_subscribers;
        }
    },
};
</script>