            <!-- Reserve Your VillaHotel Desktop Section -->
            <section id="reserve-your-villahotel-section">
                <div class="row" data-equalizer>
                    <div class="large-2 columns left-side show-for-large-up" data-equalizer-watch>
                        <h6>Reserve Your VillaHotel</h6>
                    </div>
                    <div class="large-10 medium-12 columns right-side text-center" data-equalizer-watch>
                        <form method="post" action="/reservations/" onsubmit="return false;">
	                        <input type="hidden" name="action" value="reservation">
	                        <input type="hidden" name="bedMin" id="bedMin" value="<?php echo isset($_GET['bed_min'])?$_GET['bed_min']:NULL; ?>">
	                        <input type="hidden" name="bedMax" id="bedMax" value="<?php echo isset($_GET['bed_max'])?$_GET['bed_max']:NULL; ?>">
	                        <input type="hidden" name="budgetMin" id="budgetMin" value="<?php echo isset($_GET['budget_min'])?$_GET['budget_min']:NULL; ?>">
	                        <input type="hidden" name="budgetMax" id="budgetMax" value="<?php echo isset($_GET['budget_max'])?$_GET['budget_max']:NULL; ?>">
	                        <input type="hidden" name="amenities" id="amenities" value="<?php echo isset($_GET['amenities'])?$_GET['amenities']:NULL; ?>">
                            <div class="row">
                                <div class="large-3 medium-3 columns">
                                    <label>Destination
                                        <select name="dest">
                                            <option value="all" <?php echo ($_GET['dest'] == 'all' ? 'selected="selected"':''); ?>>All</option>
                                            <option value="aspen" <?php echo ($_GET['dest'] == 'aspen' ? 'selected="selected"':''); ?>>Aspen</option>
                                            <option value="miami" <?php echo ($_GET['dest'] == 'miami' ? 'selected="selected"':''); ?>>Miami</option>
                                            <option value="saint-tropez" <?php echo ($_GET['dest'] == 'saint-tropez' ? 'selected="selected"':''); ?>>Saint-Tropez</option>
                                        </select>
                                    </label>
                                </div>
                                <div class="large-3 medium-4 small-6 columns">
                                    <label>Check-In
                                        <input type="text" name="checkInDt" id="checkInDt" placeholder="MM/DD/YYYY" value="<?php echo ($_GET['check_in']?date('m/d/Y', strtotime($_GET['check_in'])):date('m/d/Y')); ?>">
                                    </label>
                                </div>
                                <div class="large-3 medium-4 small-6 columns">
                                    <label>Check-Out
                                        <input type="text" name="checkOutDt" id="checkOutDt" placeholder="MM/DD/YYYY" value="<?php echo ($_GET['check_out']?date('m/d/Y', strtotime($_GET['check_out'])):date('m/d/Y', strtotime('+3 days'))); ?>">
                                    </label>
                                </div>
								<div class="large-1 medium-4 small-3 columns">
                                    <label>Filters</label>
                                    <button class="button tiny expand filtersBtn"><i class="fa fa-tasks"></i>
</button>
                                </div>
                                <div class="large-2 medium-4 small-9 columns">
                                    <button class="button tiny expand" onclick="submit();">FIND RESULTS</button>
                                </div>
                            </div>
                    		                    
		                    <div class="row">
			                    <div class="columns">
			                        <div class="panel text-left filtersPanel">
										<div class="row">
											<div class="columns">
												<h6>BEDROOMS</h6>
											</div>
										</div>
										<div class="row">
											<div class="small-8 small-offset-2 columns">
												<div class="range-label-holder">
													<div class="range-label">4</div>
													<div class="range-label">5</div>
													<div class="range-label">6</div>
													<div class="range-label">7</div>
													<div class="range-label" style="margin-right:0;">8+</div>
												</div>
												<div class="slider-holder">
													<div id="bedroomsSlider" class="rangeSlider"></div>
												</div>
											</div>
				                        </div>
				                        <div class="row">
					                        <div class="columns">
												<h6>PRICE RANGE</h6>
					                        </div>
				                        </div>
				                        <div class="row">
					                        <div class="small-8 small-offset-2 columns">
												<div class="range-label-holder">
													<div class="range-label">1,000</div>
													<div class="range-label">2,500</div>
													<div class="range-label">5,000</div>
													<div class="range-label">7,500</div>
													<div class="range-label" style="margin-right:0;">10,000+</div>
												</div>
												<div class="slider-holder">
													<div id="budgetSlider" class="rangeSlider"></div>
												</div>
					                        </div>
										</div>
			                            <div class="row">
				                            <div class="columns">
												<h6>AMENITIES</h6>
				                            </div>
			                            </div>
				                        <div class="row">
					                        <div class="columns">
						                        <ul class="small-block-grid-1 medium-block-grid-2 large-block-grid-3">
					                            <?php
												$rs_feature = $_SESSION['DB']->querySelect('SELECT featureId, featureReservation FROM feature WHERE featureReservation IS NOT NULL ORDER BY featureReservation ASC');
												$row_rs_feature = $_SESSION['DB']->queryResult($rs_feature);
												$totalRows_rs_feature = $_SESSION['DB']->queryCount($rs_feature);
												
												$features = NULL;
												$featureCtr = 1;
												
												$amenitiesArray = array();
												$amenitiesArray = explode(',', (isset($_GET['amenities'])?$_GET['amenities']:''));
												
												if ($totalRows_rs_feature)
												{
													$features = '';
													do {
														$features .= '	
												                    <li><input type="checkbox" id="amenity_'.$row_rs_feature['featureId'].'" class="amenities" value="'.$row_rs_feature['featureId'].'"'.(in_array($row_rs_feature['featureId'], $amenitiesArray)?' checked':'').'>
												                            <label for="amenity_'.$row_rs_feature['featureId'].'">'.str_replace('<br/>', '', $row_rs_feature['featureReservation']).'</label>
												                        </li>';
														
														// halfpoint, switch column
	/*
														if ($featureCtr == floor($totalRows_rs_feature / 4))
														{
															$features .= '	</div>
																			<div class="large-3 medium-3 small-6 columns">';
															$featureCtr = 0;
														}
	*/
														
														$featureCtr ++;
													} while ($row_rs_feature = $_SESSION['DB']->queryResult($rs_feature));
												}
	
					                            echo $features;
						                        ?>
						                        </ul>
					                        </div>
			                            </div>
			                        </div>
				                </div>
		                    </div>
                        </form>
                    </div>
                </div>
            </section>
            <!-- Reserve Your VillaHotel Desktop Secton End -->