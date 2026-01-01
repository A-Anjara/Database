import controller_0 from "../../controllers/form_controller.js";
import controller_1 from "../../controllers/date_controller.js";
import controller_2 from "../../controllers/hello_controller.js";
import controller_3 from "../../controllers/modal_controller.js";
export const eagerControllers = {"form": controller_0, "date": controller_1, "hello": controller_2, "modal": controller_3};
export const lazyControllers = {"csrf-protection": () => import("../../controllers/csrf_protection_controller.js")};
export const isApplicationDebug = false;