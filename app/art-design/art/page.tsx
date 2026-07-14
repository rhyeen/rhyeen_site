import { galleries } from "../../data";
import { GalleryPage } from "../gallery";

export const metadata = { title: "Art" };

export default function ArtPage() {
  return <GalleryPage title="Art" folder="art" images={galleries.art} />;
}
