<template>
    <grid :position="grid" modifiers="analytics padded fa fa-bars fa-sort-desc">
       <section class="google-analytics">

           <span class="total__views">Total views:
           <strong class="view__number">{{events.total_page_views | formatNumber }}</strong> 
            <small class="days">Last 5 days stats</small>
            </span>

           <ul class="google-analytics__events">
               <li v-for="event in events.top_page_views"  class="google-analytics__event">
                   <h2 class="google-analytics__event__title">{{ event.pageTitle }}</h2>
                   <div class="google-analytics__event__date">Viewed: {{ event.pageViews }} *</div>
               </li>
           </ul>
          <!-- <small>Online</small> <small class="days">{{ events.current_users_online }}</small> -->
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
        };
    },

    methods: {

        getEventHandlers() {
            return {
                'GoogleAnalytics.EventsFetched': response => {
                    this.events = response.events;
                },
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'google-analytics',
            };
        },
    },
};
</script>
