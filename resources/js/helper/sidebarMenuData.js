export function returnSideBarData() {
    const link_data = [
        //Users start here (index 0)
        {
            name: "Users",
            links: [
                {
                    link_name: "Add user",
                    link_url: "/add-user",
                    component_name: "user/adduser",
                    is_ext: false,
                    restricted_type: "admin",
                },
                {
                    link_name: "Edit user",
                    link_url: "/edit-user",
                    component_name: "user/edituser",
                    is_ext: false,
                    restricted_type: "admin",
                },
                {
                    link_name: "View users",
                    link_url: "/view-users",
                    component_name: "user/viewusers",
                    is_ext: false,
                    restricted_type: "user",
                },
            ],
        },

        //Visitors start here (index 1)

        {
            name: "Visitors",
            links: [
                {
                    link_name: "Current visitors",
                    link_url: "/current-visitor",
                    component_name: "visitors/currentvisitors",
                    is_ext: false,
                    restricted_type: "user",
                },
                {
                    link_name: "View visitors",
                    link_url: "/view-all-visitor",
                    component_name: "visitors/viewallvisitors",
                    is_ext: false,
                    restricted_type: "user",
                },
                {
                    link_name: "Visitors sign in/out",
                    link_url: "https://iv.icblog.uk/",
                    component_name: "",
                    is_ext: true,
                    restricted_type: "user",
                },
                {
                    link_name: "Visiting reasons",
                    link_url: "/visiting-reasons",
                    component_name: "visitors/visitingreasons",
                    is_ext: false,
                    restricted_type: "user",
                },
            ],
        },

        //Absence start here (index 2)

        {
            name: "Absence",
            links: [
                {
                    link_name: "Add absence",
                    link_url: "/absence/add",
                    component_name: "absence/addabsence",
                    is_ext: false,
                    restricted_type: "user",
                },
                {
                    link_name: "View absence",
                    link_url: "/absence",
                    component_name: "absence/absencehome",
                    is_ext: false,
                    restricted_type: "user",
                },
                {
                    link_name: "Absence reasons",
                    link_url: "/absence/reasons",
                    component_name: "absence/commonabsencereasons",
                    is_ext: false,
                    restricted_type: "user",
                },

            ],
        },

        //Phones start here (index 3)

        {
            name: "Phones",
            links: [
                {
                    link_name: "Add phones",
                    link_url: "/phones/add",
                    component_name: "phone/addphone",
                    is_ext: false,
                    restricted_type: "user",
                },
                {
                    link_name: "Edit phones",
                    link_url: "/phones/edit",
                    component_name: "phone/editphone",
                    is_ext: false,
                    restricted_type: "user",
                },
                {
                    link_name: "View phones",
                    link_url: "/phones",
                    component_name: "phone/phonehome",
                    is_ext: false,
                    restricted_type: "user",
                },

            ],
        },

        //Department/Company start here (index 4)

        {
            name: "Department/Company",
            links: [
                {
                    link_name: "Add new depart/comp",
                    link_url: "/departcomp/add",
                    component_name: "departcomp/adddepartmentorcompany",
                    is_ext: false,
                    restricted_type: "user",
                },
                {
                    link_name: "Manage depart/comp",
                    link_url: "/view-all-depart-comp",
                    component_name: "departcomp/viewdepartmentorcompany",
                    is_ext: false,
                    restricted_type: "user",
                },


            ],
        },

        //Lockers start here (index 5)

        {
            name: "Lockers",
            links: [
                {
                    link_name: "Add new locker",
                    link_url: "/lockers/add",
                    component_name: "locker/addlocker",
                    is_ext: false,
                    restricted_type: "user",
                },
                {
                    link_name: "Manage locker",
                    link_url: "/lockers",
                    component_name: "locker/viewlockers",
                    is_ext: false,
                    restricted_type: "user",
                },


            ],
        },

        //Keys start here (index 6)

        {
            name: "Keys",
            links: [
                {
                    link_name: "Key log",
                    link_url: "/keys/log",
                    component_name: "key/keylog",
                    is_ext: false,
                    restricted_type: "user",
                },
                {
                    link_name: "Add new key",
                    link_url: "/keys/add",
                    component_name: "key/addkey",
                    is_ext: false,
                    restricted_type: "user",
                },
                {
                    link_name: "View all keys",
                    link_url: "/view-keys",
                    component_name: "key/viewkeys",
                    is_ext: false,
                    restricted_type: "user",
                },

                {
                    link_name: "Manage key storage",
                    link_url: "/keys/storage",
                    component_name: "key/storage",
                    is_ext: false,
                    restricted_type: "user",
                },


            ],
        },


        //Temp off site start here (index 7)

        {
            name: "Temp offsite",
            links: [
                {
                    link_name: "Current temp offsite",
                    link_url: "/tempoffsite/current",
                    component_name: "tempoffsite/currenttempoffsite",
                    is_ext: false,
                    restricted_type: "user",
                },
                {
                    link_name: "View temp offsite",
                    link_url: "/tempoffsite/view",
                    component_name: "tempoffsite/viewtempoffsite",
                    is_ext: false,
                    restricted_type: "user",
                },
                {
                    link_name: "Temp offsite in/out",
                    link_url: "https://iv.icblog.uk/temp-in-out",
                    component_name: "",
                    is_ext: true,
                    restricted_type: "user",
                }
            ],
        },
    ];

    return link_data;
}// end return side bar data