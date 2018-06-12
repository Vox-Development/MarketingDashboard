<template>
    <grid :position="grid" modifiers="newsletter padded fa fa-bars fa-sort-desc">
        <section class="newsletter-statistics">
            <h1 class="heading">Newsletter <span>Stats</span></h1>
                <object type="image/svg+xml" data="/svg/newsletter-graphic.svg" class="newsletter-graphic">
                    <!-- fallback image in CSS -->
                </object>
                <ul>
                <li class="newsletter-statistics">
                    <h2 class="newsletter-statistics__period">Subscribers</h2>
                    <span class="subscribers__count">{{ events.emailContacts }}</span>
                </li>
                <li class="newsletter-statistics">
                    <h2 class="newsletter-statistics__period">Bounce</h2>
                    <span class="bounce__count">{{ events.emailContactsBounced }}</span>
                </li>
                <li class="newsletter-statistics">
                    <h2 class="newsletter-statistics__period">Unsubscribers</h2>
                    <span class="unsubscribers__count">{{ events.emailContactsUnsubscribed }}</span>
                </li>
                <li class="newsletter-statistics">
                    <h2 class="newsletter-statistics__period">Total</h2>
                    <span class="total__count">{{ getTotals() }}</span>
                </li>
            </ul>
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
        getTotals() {
            return this.events.emailContacts + this.events.emailContactsUnsubscribed + this.events.emailContactsUnsubscribed
        },
        getEventHandlers() {
            return {
                'Newsletter.NewsletterFetched': response => {
                     this.events = response.events;
                },
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'newsletter',
            };
        },
    },
};
</script>
