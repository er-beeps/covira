library(raster)
library(ggplot2)
library(rgdal)
library(tmap)
library(sf)
library(dplyr)
library(spData)
library(spDataLarge)
library(sp)
library(rgeos)
library(xlsx)

setwd("C:/working/COVID19/map_outcome/")
#admin41 < -shapefile("C:/working/COVID19/final_data_for_mapping/spatial_data/old/np_municipality_utm_population.shp")
#admin4_indicators < -shapefile("C:/working/COVID19/final_data_for_mapping/spatial_data/old/np_admin_3_4_all_indicators_may13_utm.shp")
admin4 < -shapefile("C:/working/COVID19/final_data_for_mapping/spatial_data/np_admin4_health_pop_all_indicators1.shp")

origCrs < -crs(admin4)
#Convert to utm 45 N
admin4 < -spTransform(admin4, CRS("+init=epsg:32645"))

#as.integer(admin4 @data$EXP) < -admin4_indicators @data$EXP
admin4$Density_norm < -(admin4$Density / max(admin4$Density)) * 100

#quarantine < -read.xlsx("C:/working/COVID19/final_data_for_mapping/COVID_DATA_total_cases.xlsx", sheetName = 'Quarantine', header = TRUE)

#covid_case < -read.xlsx("C:/working/COVID19/final_data_for_mapping/COVID_DATA_total_cases.xlsx", sheetName = 'COVID_Cases', header = TRUE)

# # # # # # # # # # # # # #-- -- --precovid scenario # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #

quarantine < -read.xlsx("C:/working/COVID19/final_data_for_mapping/COVID_DATA_zero_case_scenario.xlsx", sheetName = 'Quarantine', header = TRUE)
covid_case < -read.xlsx("C:/working/COVID19/final_data_for_mapping/COVID_DATA_zero_case_scenario.xlsx", sheetName = 'COVID_Cases', header = TRUE)

#Excluse all cases older than 90 days
dt_diff < -as.double(Sys.Date() - covid_case$Date)
valid < -which(dt_diff < 90)
covid_case < -covid_case[valid, ]

a < -!is.na(covid_case$Total_case)
covid_case < -covid_case[a, ]

a < -!is.na(quarantine$Quarantine)
quarantine < -quarantine[a, ]

# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #Methods # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #

regional_imp < - function (admin4) {
  admin4 @data$r_imp < -0
  admin4 @data$food < -0
  for (i in 1: length(admin4$Max_Paddy_)) {
    admin4 @data$food[i] < -max(admin4$Max_Paddy_[i], admin4$Max_Maize_[i])
    admin4 @data$r_imp[i] < -max(admin4 @data$food[i], as.numeric(admin4$SCN[i]))
  }
  return (admin4)
}

#Compute ACS is component of PCS componentof ACS
acs_value < - function (admin4, total_cases) {
  admin4 @data$computed_pcs = 0
  length < -length(admin4$PALIKA)

  for (ad4_index in 1: length) {

    #c7 = number of cases
    #D8 = total population
    if (admin4$Population[ad4_index] != 0) {
      if (admin4$cases[ad4_index] == 0) {
        admin4 @data$computed_pcs[ad4_index] < -0
      } else {

        #admin4 @data$computed_pcs[ad4_index] = 100 + (log(admin4$cases[ad4_index] / as.numeric(admin4$Population[ad4_index])) * 50 / (-log(1 / as.numeric(admin4$Population[ad4_index]))))
        a < -admin4$cases[ad4_index]
        b < -as.numeric(admin4$Population[ad4_index]) / 4.6
        if (a < b) {
          admin4 @data$computed_pcs[ad4_index] = 100 - log(a / b) * 50 / (log(1 / b))
        } else {
          admin4 @data$computed_pcs[ad4_index] = 100
        }

      }
    } else {
      admin4 @data$computed_pcs[ad4_index] < -0
    }

    '
    prop_active_cases < -admin4$cases[ad4_index] / total_cases
    if (admin4$Population[ad4_index] != 0) {
      prop_ppl < -admin4$cases[ad4_index] / admin4$Population[ad4_index]
    } else {
      admin4 @data$computed_pcs[ad4_index] < -0
    }

    if (prop_ppl == 0) {
      admin4 @data$computed_acs[ad4_index] < -0
    } else if (prop_ppl < 0.001) {
      admin4 @data$computed_acs[ad4_index] < -50 + 0.5 * prop_active_cases
    } else if (prop_ppl < 0.01) {
      admin4 @data$computed_acs[ad4_index] < -60 + 0.4 * prop_active_cases
    } else if (prop_ppl < 0.1) {
      admin4 @data$computed_acs[ad4_index] < -80 + 0.2 * prop_active_cases
    } else if (prop_ppl < 1) {
      admin4 @data$computed_acs[ad4_index] < -90 + 0.1 * prop_active_cases
    } else if (prop_ppl > 1) {
      admin4 @data$computed_acs[ad4_index] < -100
    }
    print("...................")
    '
  }
  return (admin4)

}

#Neighborhood risk transfer computation

neightborhood_weight < - function (admin4, infected_admin) {
  #admin4 is the shape file having the administrative uniits of full extension.
  #infected_admin < -is the admin list which has the quarentined or infected cases
  for (i in 1: length(infected_admin)) {
    infected_palika < -subset(admin4, index == infected_admin[i])
    #Analysis with 10 km buffer
    buffer_10km < -buffer(infected_palika, width = 1000)
    clip_10km < -intersect(admin4, buffer_10km)

    #Update the risk within 10 km buffer
    # the risk is reduced to half
    if the last
    case is greater than 60 days and 0
    if it is greater than 90 days.
    poly_to_update < -clip_10km$index
    for (index_to_update in 1: length(poly_to_update)) {
      if (!is.na(admin4$Latest_date[poly_to_update[index_to_update]])) {
        dt_dif < -as.double(Sys.Date() - admin4$Latest_date[poly_to_update[index_to_update]])
        if (dt_dif > 90) {
          risk_existing < -0
        } else if (dt_dif > 60) {
          risk_existing < -as.numeric(admin4$cases[poly_to_update[index_to_update]]) / 2
        } else {
          risk_existing < -as.numeric(admin4$cases[poly_to_update[index_to_update]])
        }
      } else {
        risk_existing < -0
      }
      if (!is.na(admin4$Latest_date[infected_admin[i]])) {
        dt_dif < -as.double(Sys.Date() - admin4$Latest_date[infected_admin[i]])
        if (dt_dif > 90) {
          risk_neighbur < -0
        } else if (dt_dif > 60) {
          risk_neighbur < -as.numeric(admin4$cases[infected_admin[i]]) / 2
        } else {
          risk_neighbur < -as.numeric(admin4$cases[infected_admin[i]])
        }
      } else {
        risk_neighbur < -0
      }

      if (!is.na(risk_existing)) {
        if (risk_neighbur > risk_existing) {
          admin4$cases[poly_to_update[index_to_update]] < -risk_neighbur / 2
        }

      } else {
        admin4$cases[poly_to_update[index_to_update]] < -risk_existing
      }

    }

    #Analysis with 10 km buffer
    buffer_20km < -buffer(infected_palika, width = 2000)
    clip_20km < -intersect(admin4, buffer_20km)
    #Update with 10 km buffer
    poly_to_update < -setdiff(clip_20km$index, clip_10km$index)
    if (length(poly_to_update) > 0) {
      for (index_to_update in 1: length(poly_to_update)) {
        if (!is.na(admin4$Latest_date[poly_to_update[index_to_update]])) {
          dt_dif < -as.double(Sys.Date() - admin4$Latest_date[poly_to_update[index_to_update]])
          if (dt_dif > 90) {
            risk_existing < -0
          } else if (dt_dif > 60) {
            risk_existing < -as.numeric(admin4$cases[poly_to_update[index_to_update]]) / 2
          } else {
            risk_existing < -as.numeric(admin4$cases[poly_to_update[index_to_update]])
          }
        } else {
          risk_existing < -0
        }
        if (!is.na(admin4$Latest_date[infected_admin[i]])) {
          dt_dif < -as.double(Sys.Date() - admin4$Latest_date[infected_admin[i]])
          if (dt_dif > 90) {
            risk_neighbur < -0
          } else if (dt_dif > 60) {
            risk_neighbur < -as.numeric(admin4$cases[infected_admin[i]]) / 2
          } else {
            risk_neighbur < -as.numeric(admin4$cases[infected_admin[i]])
          }
        } else {
          risk_neighbur < -0
        }

        if (!is.na(risk_existing)) {
          if (risk_neighbur > risk_existing) {
            admin4$cases[poly_to_update[index_to_update]] < -risk_neighbur / 2
          }

        } else {
          admin4$cases[poly_to_update[index_to_update]] < -risk_existing
        }

      }
      'for (index_to_update in 1: length(poly_to_update)){
      risk_existing < -as.numeric(admin4$cases[poly_to_update[index_to_update]])
      risk_neighbur < -as.numeric(admin4$cases[infected_admin[i]]) / 2
      if (!is.na(risk_existing)) {
        if (risk_neighbur > risk_existing) {
          admin4$cases[poly_to_update[index_to_update]] < -risk_neighbur / 2
        }

      } else {
        admin4$cases[poly_to_update[index_to_update]] < -risk_existing
      }

    }
    '
  }
}
return (admin4)
}

# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #Methods # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #3

active_cases_district <- covid_case %>%

  group_by(DISTRICT) %>%

  summarise(total_case = sum(Total_case))

active_cases < -covid_case % > %
  group_by(DISTRICT, PALIKA) % > %
  summarise(total_case = sum(Total_case), latest_date = (max(Date)))

names(active_cases) < -c("DISTRICT", "PALIKA", "Infected", "Latest_date")

admin4 < -merge(admin4, active_cases, by = c("DISTRICT", "PALIKA"), all = TRUE)

active_quarantine < -quarantine % > %
  group_by(District) % > %
  summarise(total_quarantine = sum(Quarantine))

admin4$Quarantine < -0
for (i in 1: length(active_quarantine$District)) {
  index < -which(admin4$DISTRICT == active_quarantine$District[i])
  admin4$Quarantine[index] < -active_quarantine$total_quarantine[i]

}

#covid_infected < -subset(covid_case, subset = Infected. > 1)
#infected_admin < -data.frame(covid_infected$Municipality, covid_infected$Ward, covid_infected$Infected.)
#names(infected_admin) < -c("Municipality", "Ward", "Infected")
#names(covid_case) < -c("Date", "District", "PALIKA", "WARD", "Infected", "Recovered", "Quarantine", "Isolation")
#admin4 < -merge(admin4, covid_case, by = c("PALIKA", "WARD"), all = TRUE)
admin4$Infected[is.na(admin4$Infected)] < -0
admin4$Population[is.na(admin4$Population)] < -10000000

total_active_cases < -sum(admin4$Infected[which(admin4$Infected > 0)])
total_quarentined < -sum(admin4$Quarantine[which(admin4$Quarantine > 0)])
#total_isolated < -sum(covid_case$Isolation[which(covid_case$Isolation > 0)])

admin4 @data$index[1] < -999
lnth < -length(admin4 @data$PROVINCE)
admin4 @data$index[1: lnth] < -1: lnth
infected_admin < -which(admin4$Infected > 0)
quarantine_admin < -which(admin4$Quarantine > 0)

#-- -- -- -- -- -- -- -- -- -- -- -- -- - Infected risk transfer
admin4 @data$cases < -0
admin4 @data$cases < -admin4 @data$Infected
admin4 < -neightborhood_weight(admin4, infected_admin)
admin4 @data$Infected < -admin4 @data$cases

#-- -- -- -- -- -- -- -- -- --Quarantine risk transfer
admin4 @data$cases < -0
admin4 @data$cases < -admin4 @data$Quarantine
admin4 < -neightborhood_weight(admin4, quarantine_admin)
admin4 @data$Quarantine < -admin4 @data$cases

#-- -- -- -- -- -- -- -- -- -- --Compute pcs(Positive
  case score)
admin4 @data$cases < -0
admin4 @data$cases < -admin4 @data$Infected
admin4 < -acs_value(admin4, total_active_cases)
admin4 @data$pcs < -admin4 @data$computed_pcs

#-- -- -- -- -- -- -- -- -- -- -- --Compute QNT(Quarantined people score) risk score
admin4 @data$cases < -0
admin4 @data$cases < -admin4 @data$Quarantine
admin4 < -acs_value(admin4, total_quarentined)
admin4 @data$qnt < -admin4 @data$computed_pcs

admin4 < -regional_imp(admin4)

admin4 @data$CTR < -0
admin4 @data$CTR < -0.6 * admin4$pcs + 0.2 * admin4$Density_norm + 0.1 * admin4$qnt + 0.1 * as.numeric(admin4$EXP)

admin4$TRS_r_pp < -0
admin4$TRS_r_pp < -0.8 * admin4$CTR + 0.2 * ((0.6 * admin4$r_PHR_pp + 0.4 * admin4$SER))

admin4$TRS_r_t < -0
admin4$TRS_r_t < -0.8 * admin4$CTR + 0.2 * (0.6 * (admin4$r_PHR_t + 0.4 * admin4$SER))

admin4$local_leve < -as.numeric(substr(admin4$local_leve, start = 1, stop = 5))

admin4 < -spTransform(admin4, CRS("+proj=longlat +datum=WGS84"))

# # # # # # # # # # # # # # # # # # # # # # # # # # #-- -- -- -- -- - Map writing-- -- -- -- -- -- -- -- --# # # # # # # # # # # # # # # # # # # # # # # #
#writeOGR(admin4, ".", "__covid19_nov_02_risk", driver = "ESRI Shapefile")
writeOGR(admin4, ".", "___precovid", driver = "ESRI Shapefile")

# # # # # # # # # # # # # # # # # # # # # # # # # # #-- -- -- -- -- - Excel_sheet-- -- -- -- -- -- -- -- --# # # # # # # # # # # # # # # # # # # # # # # #
req_data < -data.frame(admin4$DISTRICT, admin4$GaPa_NaPa, admin4$Type_GN, admin4$lat, admin4$long, admin4$local_leve, admin4$CTR, admin4$TRS_r_t)
index_na < -which(!is.na(req_data$admin4.local_leve))
req_data < -req_data[index_na, ]
dup_dt < -duplicated(req_data$admin4.local_leve)
req_data < -req_data[!dup_dt, ]
names(req_data) < -c("district_name", "gapa_napa", "gapa_napa_type", "lat", "long", "code", "ctr", "trs")
#write.csv(req_data, "__covid19_nov_02_risk.csv")
write.csv(req_data, "___precovid.csv")

#Overall computatioin