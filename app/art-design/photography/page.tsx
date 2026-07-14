import { galleries } from "../../data";
import { GalleryPage } from "../gallery";

export const metadata = { title: "Photography" };

export default function PhotographyPage() {
  return <GalleryPage title="Photography" folder="photography" images={galleries.photography} />;
}
