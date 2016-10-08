            <!-- Reserve Your VillaHotel Desktop Section -->
            <section id="reserve-your-villahotel-section">
                <div class="row" data-equalizer>
                    <div class="large-2 columns left-side show-for-large-up" data-equalizer-watch>
                        <h6>Reserve Your VillaHotel</h6>
                    </div>
                    <div class="large-10 medium-12 columns right-side text-center" data-equalizer-watch>
                        <form method="post" action="/reservations/" onsubmit="return false;">
	                        <input type="hidden" name="action" value="reservation">
	                        <input type="hidden" name="bedMin" id="bedMin">
	                        <input type="hidden" name="bedMax" id="bedMax">
	                        <input type="hidden" name="budgetMin" id="budgetMin">
	                        <input type="hidden" name="budgetMax" id="budgetMax">
	                        <input type="hidden" name="amenities" id="amenities">
                            <div class="row">
                                <div class="large-4 medium-3 small-3 columns">
                                    <label>Destination
                                        <select name="dest">
                                            <option value="all" <?php echo ($_GET['dest'] == 'all' ? 'selected="selected"':''); ?>>All</option>
                                            <option value="aspen" <?php echo ($_GET['dest'] == 'aspen' ? 'selected="selected"':''); ?>>Aspen</option>
                                            <option value="miami" <?php echo ($_GET['dest'] == 'miami' ? 'selected="selected"':''); ?>>Miami</option>
                                            <option value="saint-tropez" <?php echo ($_GET['dest'] == 'saint-tropez' ? 'selected="selected"':''); ?>>Saint-Tropez</option>
                                        </select>
                                    </label>
                                </div>
                                <div class="large-3 medium-3 small-4 columns">
                                    <label>Check-In
                                        <input type="text" name="checkInDt" id="checkInDt" placeholder="MM/DD/YYYY" value="<?php echo ($_GET['check_in']?date('m/d/Y', strtotime($_GET['check_in'])):date('m/d/Y', strtotime('+7 days'))); ?>">
                                    </label>
                                </div>
                                <div class="large-3 medium-3 small-4 columns">
                                    <label>Check-Out
                                        <input type="text" name="checkOutDt" id="checkOutDt" placeholder="MM/DD/YYYY" value="<?php echo ($_GET['check_out']?date('m/d/Y', strtotime($_GET['check_out'])):date('m/d/Y', strtotime('+14 days'))); ?>">
                                    </label>
                                </div>
                                <div class="large-2 medium-3 small-6 columns">
                                    <button class="button tiny expand" onclick="submit();">FIND RESULTS</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
            <!-- Reserve Your VillaHotel Desktop Secton End -->