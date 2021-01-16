#http: //papacochon.com/2015/10/18/Codage-12-r-visualization-3-bubble-bar-on-map/
library(raster)
library(ggplot2)
library(rgeos)
library(tmap)
setwd("C:/working/COVID19/map_outcome/")

shp < -shapefile("C:/working/COVID19/map_outcome/__covid19_Oct_06_risk.shp")

admin0 < -shapefile("C:/working/COVID19/spatial_data/admin0.shp")
np_admin_3 < -shapefile("C:/working/COVID19/spatial_data/np_district.shp")
national_parks < -shapefile("C:/working/COVID19/spatial_data/national_parks.shp")

shp < -spTransform(shp, crs(admin0))
tmap_mode("plot")
#tmap_mode("view")

# === === === === === === == CTR === === === === ===
    #-- -- -- -- -- -- - perperson
max < -100
png("___1ctr_oct_06.png", width = 6, height = 4, units = "in", res = 500);
tm_shape(shp) +
    tm_borders(col = "white", lwd = 0.1, lty = "solid", alpha = NA) +
    tm_fill(col = "CTR", palette = "-RdYlGn",
        style = "cont", breaks = c(0, 1 * max / 4, 2 * max / 4, 3 * max / 4, max), labels = c("Very Low", "Low", "Moderate", "High", "Very high"),
        title = "COVID-19 Transfer Risk", legend.show = TRUE, labels.size = 0.3) +
    tm_layout(legend.position = c(0.01, 0.01), legend.text.size = 0.5,
        legend.title.size = 0.6) +
    #tm_legend(position = c("right", "top"))
tm_compass(position = c(0.9, 0.8), size = 1, color.light = "grey90") +
    #tm_credits("September 19", position = c(0.01, 0.24), size = 0.6) +
    tm_shape(national_parks) +
    tm_fill(col = '#006633') +
    tm_grid(n.x = 7, n.y = 5, lwd = 0.5, col = "grey90", labels.size = .4) +
    tm_scale_bar(position = c(0.2, 0.01), text.size = 0.5) +
    tm_shape(np_admin_3) +
    tm_borders(col = "grey50", lwd = 0.5, lty = "solid", alpha = 0.50) +
    tm_text("DISTRICT", size = 0.20, remove.overlap = TRUE) +
    tm_logo("C:/working/COVID19/source/logo.png", height = 3, position = c(0.6, 0.78)) +
    tm_layout(title = "www.covira.info", title.position = c(0.61, 0.78), title.size = 0.5)

dev.off()

#-- -- -- -- -- -- - total
png("__trs_Oct_06_total_ppl.png", width = 6, height = 4, units = "in", res = 500);
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
    #tm_credits("September 19", position = c(0.01, 0.24), size = 0.6) +
    tm_shape(national_parks) +
    tm_fill(col = '#006633') +
    tm_grid(n.x = 7, n.y = 5, lwd = 0.5, col = "grey90", labels.size = .4) +
    tm_scale_bar(position = c(0.2, 0.01), text.size = 0.5) +
    tm_shape(np_admin_3) +
    tm_borders(col = "grey50", lwd = 0.5, lty = "solid", alpha = 0.50) +
    tm_text("DISTRICT", size = 0.25, remove.overlap = TRUE) +
    tm_logo("C:/working/COVID19/source/logo.png", height = 3, position = c(0.6, 0.78)) +
    tm_layout(title = "www.covira.info", title.position = c(0.61, 0.78), title.size = 0.5)
dev.off()

# # # # # # # # # # # # # # #Base
case -- -- -- -- -- - # # # # # # # # # # # # # # # #3

max <- max(shp$CTR)

png("__1_ctr_relative_risk.png", width= 6, height = 4, units = "in", res = 500);
tm_shape(shp) +
    tm_borders(col = "white", lwd = 0.1, lty = "solid", alpha = NA) +
    tm_fill(col = "CTR", palette = "-RdYlGn",
        style = "cont", breaks = c(0, 1 * max / 4, 2 * max / 4, 3 * max / 4, max), labels = c("Very Low", " ", " ", " ", "Very high"),
        title = "Relative Risk - CTR", legend.show = TRUE, labels.size = 0.3) +
    tm_layout(legend.position = c(0.01, 0.01), legend.text.size = 0.5,
        legend.title.size = 0.6) +
    #tm_legend(position = c("right", "top"))
tm_compass(position = c(0.9, 0.8), size = 1, color.light = "grey90") +
    tm_credits("january 1", position = c(0.01, 0.24), size = 0.6) +
    tm_shape(national_parks) +
    tm_fill(col = '#006633') +
    tm_grid(n.x = 7, n.y = 5, lwd = 0.5, col = "grey90", labels.size = .4) +
    tm_scale_bar(position = c(0.2, 0.01), text.size = 0.5) +
    tm_shape(np_admin_3) +
    tm_borders(col = "grey50", lwd = 0.5, lty = "solid", alpha = 0.50) +
    tm_text("DISTRICT", size = 0.25, remove.overlap = TRUE) +
    tm_logo("C:/Users/bmishra/Dropbox/_Science_Hub/logo.png", height = 3, position = c(0.6, 0.78)) +
    tm_layout(title = "www.covira.info", title.position = c(0.61, 0.78), title.size = 0.5)

dev.off()

#-- -- -- -- -- -- - total
png("__1_trs_relative_risk_jan1.png", width = 6, height = 4, units = "in", res = 500);
max < -max(shp$TRS_r_t)
tm_shape(shp) +
    tm_borders(col = "white", lwd = 0.1, lty = "solid", alpha = NA) +
    tm_fill(col = "TRS_r_t", palette = "-RdYlGn",
        style = "cont", breaks = c(0, 1 * max / 4, 2 * max / 4, 3 * max / 4, max), labels = c("Very Low", " ", " ", " ", "Very high"),
        title = "Relative Risk - TRS", legend.show = TRUE, labels.size = 0.3) +
    tm_layout(legend.position = c(0.01, 0.01), legend.text.size = 0.5,
        legend.title.size = 0.6) +
    tm_compass(position = c(0.9, 0.8), size = 1, color.light = "grey90") +
    tm_credits("january 1", position = c(0.01, 0.24), size = 0.6) +
    tm_shape(national_parks) +
    tm_fill(col = '#006633') +
    tm_grid(n.x = 7, n.y = 5, lwd = 0.5, col = "grey90", labels.size = .4) +
    tm_scale_bar(position = c(0.2, 0.01), text.size = 0.5) +
    tm_shape(np_admin_3) +
    tm_borders(col = "grey50", lwd = 0.5, lty = "solid", alpha = 0.50) +
    tm_text("DISTRICT", size = 0.25, remove.overlap = TRUE) +
    tm_logo("C:/Users/bmishra/Dropbox/_Science_Hub/logo.png", height = 3, position = c(0.6, 0.78)) +
    tm_layout(title = "www.covira.info", title.position = c(0.61, 0.78), title.size = 0.5)
dev.off()