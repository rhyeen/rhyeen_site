import { galleries } from "../../data";
import { GalleryPage } from "../gallery";

export const metadata = { title: "Graphic Design" };

export default function GraphicDesignPage() {
  return <GalleryPage title="Graphic design" folder="graphic-design" images={galleries["graphic-design"]} />;
}
