<template>
    <grid :position="grid" modifiers="pipedrive padded fa fa-bars fa-sort-desc">
        <section class="pipedrive-statistics">
            <h1 class="heading">Pipedrive <span>Stats</span></h1>
            <object type="image/svg+xml" data="/svg/pipedrive-graphic.svg" class="pipedrive-graphic">
                    <!-- fallback image in CSS -->
                </object>
                <ul>
                <li class="pipedrive-statistics">
                    <h2 class="pipedrive-statistics__period">Marketing Leads</h2>
                    <span class="marketing_leads__count">{{ events.TotalLeadsIn }}</span>
                </li>
                <li class="pipedrive-statistics">
                    <h2 class="pipedrive-statistics__period">Total Deals Won</h2>
                    <span class="deals_won__count">{{ events.TotalDealsWon }}</span>
                </li>
                <li class="pipedrive-statistics">
                    <h2 class="pipedrive-statistics__period">Total Deals Lost</h2>
                    <span class="deals_lost__count">{{ events.TotalDealsLost }}</span>
                </li>

                <li class="pipedrive-statistics">
                    <h2 class="pipedrive-statistics__period">30 Days</h2>
                    <span class="days__count">{{ events.TotalLeadsInToday + 30 }}</span>
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
        getEventHandlers() {
            return {
                'Pipedrive.EventsFetched': response => {
                     this.events = response.events;
                },
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'pipedrive',
            };
        },
    },
};
</script>
