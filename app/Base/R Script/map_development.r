#http: //papacochon.com/2015/10/18/Codage-12-r-visualization-3-bubble-bar-on-map/
library(raster)
library(ggplot2)
library(rgeos)
library(tmap)
setwd("C:/working/COVID19/map_outcome/")

shp < -shapefile("C:/working/COVID19/map_outcome/covid19_July_25.shp")

#shp < -shapefile("C:/working/COVID19/final_data_for_mapping/spatial_data/local_supply_chain_risk_score.shp")
#shp < -shapefile("C:/working/COVID19/map_outcome/zero_case_scenario.shp")
#shp < -shapefile("C:/working/COVID19/final_data_for_mapping/spatial_data/np_admin4_health_pop_all_indicators.shp")
admin0 < -shapefile("C:/working/COVID19/spatial_data/admin0.shp")
np_admin_3 < -shapefile("C:/working/COVID19/spatial_data/np_district.shp")
national_parks < -shapefile("C:/working/COVID19/spatial_data/national_parks.shp")

shp < -spTransform(shp, crs(admin0))
tmap_mode("plot")
#tmap_mode("view")

# === === === === === === == CTR === === === === ===
  #-- -- -- -- -- -- - perperson
max < -100
png("ctr_July_25.png", width = 6, height = 4, units = "in", res = 500);
tm_shape(shp) +
  tm_borders(col = "white", lwd = 0.1, lty = "solid", alpha = NA) +
  tm_fill(col = "CTR", palette = "-RdYlGn",
    style = "cont", breaks = c(0, 1 * max / 4, 2 * max / 4, 3 * max / 4, max), labels = c("Very Low", "Low", "Moderate", "High", "Very high"),
    title = "COVID-19 Transfer Risk", legend.show = TRUE, labels.size = 0.3) +
  tm_layout(legend.position = c(0.01, 0.01), legend.text.size = 0.5,
    legend.title.size = 0.6) +
  #tm_legend(position = c("right", "top"))
tm_compass(position = c(0.9, 0.8), size = 1, color.light = "grey90") +
  tm_credits("July  25", position = c(0.01, 0.24), size = 0.6) +
  tm_shape(national_parks) +
  tm_fill(col = '#006633') +
  tm_grid(n.x = 7, n.y = 5, lwd = 0.5, col = "grey90", labels.size = .4) +
  tm_scale_bar(position = c(0.2, 0.01), text.size = 0.5) +
  tm_shape(np_admin_3) +
  tm_borders(col = "grey50", lwd = 0.5, lty = "solid", alpha = 0.50) +
  tm_text("DISTRICT", size = 0.25, remove.overlap = TRUE)

dev.off()

#-- -- -- -- -- -- - total
png("trs_July_25_total_ppl.png", width = 6, height = 4, units = "in", res = 500);
max < -100
tm_shape(shp) +
  tm_borders(col = "white", lwd = 0.1, lty = "solid", alpha = NA) +
  tm_fill(col = "TRS_r_t", palette = "-RdYlGn",
    style = "cont", breaks = c(0, 1 * max / 4, 2 * max / 4, 3 * max / 4, max), labels = c("Very Low", "Low", "Moderate", "High", "Very high"),
    title = "Overall Risk Level", legend.show = TRUE, labels.size = 0.3) +
  tm_layout(legend.position = c(0.01, 0.01), legend.text.size = 0.5,
    legend.title.size = 0.6) +
  #tm_legend(position = c("right", "top"))
tm_compass(position = c(0.9, 0.8), size = 1, color.light = "grey90") +
  tm_credits("July 25", position = c(0.01, 0.24), size = 0.6) +
  tm_shape(national_parks) +
  tm_fill(col = '#006633') +
  tm_grid(n.x = 7, n.y = 5, lwd = 0.5, col = "grey90", labels.size = .4) +
  tm_scale_bar(position = c(0.2, 0.01), text.size = 0.5) +
  tm_shape(np_admin_3) +
  tm_borders(col = "grey50", lwd = 0.5, lty = "solid", alpha = 0.50) +
  tm_text("DISTRICT", size = 0.25, remove.overlap = TRUE)
dev.off()

# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #Base Map # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #

max < -max(shp$CTR)
png("ctr_relative_risk.png", width = 6, height = 4, units = "in", res = 500);
tm_shape(shp) +
  tm_borders(col = "white", lwd = 0.1, lty = "solid", alpha = NA) +
  tm_fill(col = "CTR", palette = "-RdYlGn",
    style = "cont", breaks = c(0, 1 * max / 4, 2 * max / 4, 3 * max / 4, max), labels = c("Very Low", " ", " ", " ", "Very high"),
    title = "Relative Risk - CTR", legend.show = TRUE, labels.size = 0.3) +
  tm_layout(legend.position = c(0.01, 0.01), legend.text.size = 0.5,
    legend.title.size = 0.6) +
  #tm_legend(position = c("right", "top"))
tm_compass(position = c(0.9, 0.8), size = 1, color.light = "grey90") +
  tm_credits(" ", position = c(0.01, 0.24), size = 0.6) +
  tm_shape(national_parks) +
  tm_fill(col = '#006633') +
  tm_grid(n.x = 7, n.y = 5, lwd = 0.5, col = "grey90", labels.size = .4) +
  tm_scale_bar(position = c(0.2, 0.01), text.size = 0.5) +
  tm_shape(np_admin_3) +
  tm_borders(col = "grey50", lwd = 0.5, lty = "solid", alpha = 0.50) +
  tm_text("DISTRICT", size = 0.25, remove.overlap = TRUE)

dev.off()

#-- -- -- -- -- -- - total
png("trs_relative_risk.png", width = 6, height = 4, units = "in", res = 500);
max < -max(shp$TRS_r_t)
tm_shape(shp) +
  tm_borders(col = "white", lwd = 0.1, lty = "solid", alpha = NA) +
  tm_fill(col = "TRS_r_t", palette = "-RdYlGn",
    style = "cont", breaks = c(0, 1 * max / 4, 2 * max / 4, 3 * max / 4, max), labels = c("Very Low", " ", " ", " ", "Very high"),
    title = "Relative Risk - TRS", legend.show = TRUE, labels.size = 0.3) +
  tm_layout(legend.position = c(0.01, 0.01), legend.text.size = 0.5,
    legend.title.size = 0.6) +
  tm_compass(position = c(0.9, 0.8), size = 1, color.light = "grey90") +
  tm_credits(" ", position = c(0.01, 0.24), size = 0.6) +
  tm_shape(national_parks) +
  tm_fill(col = '#006633') +
  tm_grid(n.x = 7, n.y = 5, lwd = 0.5, col = "grey90", labels.size = .4) +
  tm_scale_bar(position = c(0.2, 0.01), text.size = 0.5) +
  tm_shape(np_admin_3) +
  tm_borders(col = "grey50", lwd = 0.5, lty = "solid", alpha = 0.50) +
  tm_text("DISTRICT", size = 0.25, remove.overlap = TRUE)
dev.off()

# # # # # # # # # # # # # # # # # # # # # # # # # # # # #Map
for regional importance - food security and supply chain
#setwd("C:/working/COVID19/map_outcome/")
#admin4_indicators < -shapefile("C:/working/COVID19/final_data_for_mapping/spatial_data/np_admin_3_4_all_indicators_may13_utm.shp")
#np_admin_3 < -shapefile("np_admin_3_ser.shp")
#road < -shapefile()
#shp < -admin4_indicators

max < -100
png("ser.png", width = 6, height = 4, units = "in", res = 500);
tm_shape(shp) +
  tm_borders(col = "grey50", lwd = 0.5, lty = "solid", alpha = 0.50) +
  tm_fill(col = "SERI_Rlt", palette = "-RdYlGn",
    style = "cont", breaks = c(0, 1 * max / 4, 2 * max / 4, 3 * max / 4, max), labels = c("Very Low", "Low", "Moderate", "High", "Very high"),
    title = "Socioeconomic Risk ", legend.show = TRUE, labels.size = 0.3) +
  tm_layout(legend.position = c(0.01, 0.01), legend.text.size = 0.5,
    legend.title.size = 0.6) +
  tm_compass(position = c(0.9, 0.8), size = 1, color.light = "grey90") +
  tm_grid(n.x = 7, n.y = 5, lwd = 0.5, col = "grey90", labels.size = .4) +
  tm_scale_bar(position = c(0.2, 0.01), text.size = 0.5) +
  tm_shape(np_admin_3) +
  tm_borders(col = "grey50", lwd = 0.1, lty = "solid", alpha = NA) +
  tm_text("DISTRICT", size = 0.25, remove.overlap = TRUE)
dev.off()

#-- -- -- -- -- - food important map-- -- -- -- -- -- -- -- --

shp < -regional_imp(admin4_indicators)
png("_food.png", width = 6, height = 4, units = "in", res = 500);
tm_shape(shp) +
  tm_borders(col = "white", lwd = 0.25, lty = "solid", alpha = 0.50) +
  tm_fill(col = "food", palette = "BuGn",
    style = "cont", breaks = c(0, 25, 50, 75, 100), labels = c("Low", " ", " ", " ", "High"),
    title = "Regional importance - Food ", legend.show = TRUE, labels.size = 0.3) +
  tm_layout(legend.position = c(0.01, 0.01), legend.text.size = 0.5,
    legend.title.size = 0.6) +
  tm_shape(national_parks) +
  tm_fill(col = '#ccebe4') +
  tm_compass(position = c(0.9, 0.8), size = 1, color.light = "grey90") +
  tm_grid(n.x = 7, n.y = 5, lwd = 0.5, col = "grey90", labels.size = .4) +
  tm_scale_bar(position = c(0.2, 0.01), text.size = 0.5) +
  tm_shape(np_admin_3) +
  tm_borders(col = "grey50", lwd = 0.1, lty = "solid", alpha = NA) +
  tm_text("DISTRICT", size = 0.25, remove.overlap = TRUE)
dev.off()

# # # # # # # # # # # # # # # # # Socioeconomic 00-- -- -- -- -- -- -- -- -- -- -- -- -- -- -

# # # # # # # # # # # # # # # # # Supply chain 00-- -- -- -- -- -- -- -- -- -- -- -- -- -- -
#road < -shapefile("C:/working/COVID19/spatial_data/NPL_rds/NPL_roads")
shp < -shapefile("C:/working/COVID19/final_data_for_mapping/spatial_data/local_supply_chain_risk_score.shp")
road_st < -shapefile("C:/working/COVID19/spatial_data/Strategic_Road_Network/Strategic Roads nepal.shp")
road_d < -shapefile("C:/working/COVID19/spatial_data/District_road/DRCN_All_Districts.shp")
max < -100
shp$Scrore < -as.numeric(shp$Scrore)
png("sci_b.png", width = 6, height = 4, units = "in", res = 500);
tm_shape(shp) +
  tm_borders(col = "grey50", lwd = 0.2, lty = "solid", alpha = 0.50) +
  tm_fill(col = "Scrore", palette = "BuGn",
    style = "cont", breaks = c(0, 1 * max / 4, 2 * max / 4, 3 * max / 4, max), labels = c("Very Low", " ", " ", " ", "Very high"),
    title = "Supply Chain Importance ", legend.show = TRUE, labels.size = 0.3) +
  tm_compass(position = c(0.9, 0.8), size = 1, color.light = "grey90") +
  tm_grid(n.x = 7, n.y = 5, lwd = 0.5, col = "grey90", labels.size = .4) +
  tm_scale_bar(position = c(0.2, 0.01), text.size = 0.5) +
  tm_shape(national_parks) +
  tm_fill(col = '#006633') +
  tm_shape(road_st) +
  tm_lines(col = "#7A3232", lwd = 0.6, lty = "solid", alpha = NA) +
  tm_add_legend(type = "line", col = "#7A3232", labels = "Major Road Network") +
  #tm_shape(road_d) +
  # tm_lines(col = "black", lwd = 0.2, lty = "solid", alpha = NA) +
  #tm_add_legend(type = "line", col = "black", labels = "Local Road Networks") +
  tm_shape(np_admin_3) +
  tm_borders(col = "grey50", lwd = 0.1, lty = "solid", alpha = NA) +
  tm_text("DISTRICT", size = 0.25, remove.overlap = TRUE) +
  tm_layout(legend.position = c(0.01, 0.01), legend.text.size = 0.5,
    legend.title.size = 0.6)
dev.off()

#PHR-- -- -- -- -- -- -- -- -- --

maxVal < -max(shp$r_PHR_p)
png("_phr_t_u.png", width = 6, height = 4, units = "in", res = 500);
tm_shape(shp) +
  tm_borders(col = "white", lwd = 0.1, lty = "solid", alpha = NA) +
  tm_fill(col = "r_PHR_t", palette = "-RdYlGn",
    style = "cont", breaks = c(0, 1 * (maxVal / 6), 2 * (maxVal / 6), 3 * (maxVal / 6), 4 * maxVal / 6), labels = c("Very Low", "Low", "Moderate", "High", "Very high"),
    title = "Public Health Risk  ", legend.show = TRUE, labels.size = 0.3) +
  tm_layout(legend.position = c(0.01, 0.01), legend.text.size = 0.5,
    legend.title.size = 0.6) +
  #tm_legend(position = c("right", "top"))
tm_compass(position = c(0.9, 0.8), size = 1, color.light = "grey90") +
  tm_shape(national_parks) +
  tm_fill(col = '#006633') +
  tm_grid(n.x = 7, n.y = 5, lwd = 0.5, col = "grey90", labels.size = .4) +
  tm_scale_bar(position = c(0.2, 0.01), text.size = 0.5) +
  tm_shape(np_admin_3) +
  tm_borders(col = "grey50", lwd = 0.5, lty = "solid", alpha = 0.50) +
  tm_text("DISTRICT", size = 0.25, remove.overlap = TRUE)
dev.off()

#UHC-- -- -- -- -- -- -- -- -- --
#shp < -admin4_indicators
#shp$r_UHC_p
#shp$r_UHC
maxVal < -max(shp$r_UHC)
png("_uhc_t.png", width = 6, height = 4, units = "in", res = 500);
tm_shape(shp) +
  tm_borders(col = "white", lwd = 0.1, lty = "solid", alpha = NA) +
  tm_fill(col = "r_UHC", palette = "-RdYlGn",
    style = "cont", breaks = c(0, 1 * (maxVal / 4), 2 * (maxVal / 4), 3 * (maxVal / 4), 4 * maxVal / 4), labels = c("Very Low", "Low", "Moderate", "High", "Very high"),
    title = "Health Condition ", legend.show = TRUE, labels.size = 0.3) +
  tm_layout(legend.position = c(0.01, 0.01), legend.text.size = 0.5,
    legend.title.size = 0.6) +
  #tm_legend(position = c("right", "top"))
tm_compass(position = c(0.9, 0.8), size = 1, color.light = "grey90") +
  tm_shape(national_parks) +
  tm_fill(col = '#006633') +
  tm_grid(n.x = 7, n.y = 5, lwd = 0.5, col = "grey90", labels.size = .4) +
  tm_scale_bar(position = c(0.2, 0.01), text.size = 0.5) +
  tm_shape(np_admin_3) +
  tm_borders(col = "grey50", lwd = 0.5, lty = "solid", alpha = 0.50) +
  tm_text("DISTRICT", size = 0.25, remove.overlap = TRUE)
dev.off()

max < -100

#Regional importance
png("regioinal_importance.png", width = 6, height = 4, units = "in", res = 500);
tm_shape(shp) +
  tm_borders(col = "white", lwd = 0.1, lty = "solid", alpha = NA) +
  tm_fill(col = "r_imp", palette = "-RdYlGn",
    style = "cont", breaks = c(0, 1 * (maxVal / 5), 2 * (maxVal / 5), 3 * (maxVal / 5), 4 * maxVal / 5), labels = c("Very Low", "Low", "Moderate", "High", "Very high"),
    title = "Regional", legend.show = TRUE, labels.size = 0.3) +
  tm_layout(legend.position = c(0.01, 0.01), legend.text.size = 0.5,
    legend.title.size = 0.6) +
  #tm_legend(position = c("right", "top"))
tm_compass(position = c(0.9, 0.8), size = 1, color.light = "grey90") +
  tm_grid(n.x = 7, n.y = 5, lwd = 0.5, col = "grey90", labels.size = .4) +
  tm_scale_bar(position = c(0.2, 0.01), text.size = 0.5) +
  tm_shape(np_admin_3) +
  tm_borders(col = "grey50", lwd = 0.5, lty = "solid", alpha = 0.50) +
  tm_text("DISTRICT", size = 0.3)
dev.off()

#HPI
png("hpi.png", width = 4, height = 3, units = "in", res = 500);
tm_shape(shp) +
  tm_borders(col = "white", lwd = 0.5, lty = "solid", alpha = NA) +
  tm_polygons(col = "Max_HPI", title = "HPI", palette = "-RdYlGn",
    style = "cont", breaks = c(0, 20, 40, 60, 80), labels = c("Very Low", "Low", "Moderate", "High", "Very high")) +
  tm_layout(legend.position = c(0.01, 0.01), legend.text.size = 1, legend.height = 0.5) +
  #tm_legend(position = c("right", "top"))
tm_compass(position = c(0.9, 0.8), size = 1, color.light = "grey90") +
  tm_grid(n.x = 7, n.y = 5, lwd = 0.5, col = "grey90") +
  tm_scale_bar(position = c(0.2, 0.01), text.size = 0.5) +
  tm_shape(admin0) +
  tm_borders()
dev.off()

#Hypertensi
png("Hypertensi.png", width = 4, height = 3, units = "in", res = 500);
tm_shape(shp) +
  tm_borders(col = "white", lwd = 0.5, lty = "solid", alpha = NA) +
  tm_polygons(col = "Hypertensi", palette = "-RdYlGn",
    style = "cont") +
  tm_layout(legend.position = c(0.01, 0.01), legend.text.size = 1, legend.height = 0.4) +
  #tm_legend(position = c("right", "top"))
tm_compass(position = c(0.9, 0.8), size = 1, color.light = "grey90") +
  tm_grid(n.x = 7, n.y = 5, lwd = 0.5, col = "grey90") +
  tm_scale_bar(position = c(0.2, 0.01), text.size = 0.5) +
  tm_shape(admin0) +
  tm_borders()
dev.off()

#shp$UHC
#UHC
png("UHC.png", width = 4, height = 3, units = "in", res = 500);
tm_shape(shp) +
  tm_borders(col = "white", lwd = 0.5, lty = "solid", alpha = NA) +
  tm_polygons(col = "UHC", palette = "-RdYlGn",
    style = "cont") +
  tm_layout(legend.position = c(0.01, 0.01), legend.text.size = 1, legend.height = 0.4) +
  #tm_legend(position = c("right", "top"))
tm_compass(position = c(0.9, 0.8), size = 1, color.light = "grey90") +
  tm_grid(n.x = 7, n.y = 5, lwd = 0.5, col = "grey90") +
  tm_scale_bar(position = c(0.2, 0.01), text.size = 0.5) +
  tm_shape(admin0) +
  tm_borders()
dev.off()

#shp$PHR
#PHR
png("PHR.png", width = 4, height = 3, units = "in", res = 500);
tm_shape(shp) +
  tm_borders(col = "white", lwd = 0.5, lty = "solid", alpha = NA) +
  tm_polygons(col = "PHR", palette = "-RdYlGn",
    style = "cont") +
  tm_layout(legend.position = c(0.01, 0.01), legend.text.size = 1, legend.height = 0.4) +
  #tm_legend(position = c("right", "top"))
tm_compass(position = c(0.9, 0.8), size = 1, color.light = "grey90") +
  tm_grid(n.x = 7, n.y = 5, lwd = 0.5, col = "grey90") +
  tm_scale_bar(position = c(0.2, 0.01), text.size = 0.5) +
  tm_shape(admin0) +
  tm_borders()
dev.off()